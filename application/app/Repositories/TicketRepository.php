<?php

/** --------------------------------------------------------------------------------
 * This repository class manages all the data absctration for tickets
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Repositories;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Log;

class TicketRepository {

    /**
     * The tickets repository instance.
     */
    protected $tickets;

    /**
     * Inject dependecies
     */
    public function __construct(Ticket $tickets) {
        $this->tickets = $tickets;
    }

    /**
     * Search model
     * @param int $id optional for getting a single, specified record
     * @param array $data optional data payload
     * @return object ticket collection
     */
    public function search($id = '', $data = array()) {

        $tickets = $this->tickets->newQuery();

        //default - always apply filters
        if (!isset($data['apply_filters'])) {
            $data['apply_filters'] = true;
        }

        //we are searching, turn off filters
        if (request()->filled('search_query')) {
            $data['apply_filters'] = false;
        }

        // all client fields
        $tickets->selectRaw('*');

        //joins
        $tickets->leftJoin('clients', 'clients.client_id', '=', 'tickets.ticket_clientid');
        $tickets->leftJoin('users', 'users.id', '=', 'tickets.ticket_creatorid');
        $tickets->leftJoin('categories', 'categories.category_id', '=', 'tickets.ticket_categoryid');
        $tickets->leftJoin('projects', 'projects.project_id', '=', 'tickets.ticket_projectid');
        $tickets->leftJoin('tickets_status', 'tickets_status.ticketstatus_id', '=', 'tickets.ticket_status');
        $tickets->leftJoin('pinned', function ($join) {
            $join->on('pinned.pinnedresource_id', '=', 'tickets.ticket_id')
                ->where('pinned.pinnedresource_type', '=', 'ticket');
            if (auth()->check()) {
                $join->where('pinned.pinned_userid', auth()->id());
            }
        });

        //join: users reminders - do not do this for cronjobs
        if (auth()->check()) {
            $tickets->leftJoin('reminders', function ($join) {
                $join->on('reminders.reminderresource_id', '=', 'tickets.ticket_id')
                    ->where('reminders.reminderresource_type', '=', 'ticket')
                    ->where('reminders.reminder_userid', '=', auth()->id());
            });
        }

        //default where
        $tickets->whereRaw("1 = 1");

        //filter for active or archived (default to active) - do not use this when a ticket id has been specified
        if (!is_numeric($id) && !is_array($id)) {
            if (!request()->filled('filter_show_archived_tickets') || request('filter_show_archived_tickets') == 'no') {
                $tickets->where('ticket_active_state', 'active');
            }
        }

        if (is_numeric($id)) {
            $tickets->where('ticket_id', $id);
        }

        //list of items
        if (is_array($id)) {
            $tickets->whereIn('ticket_id', $id);
        }

        //apply filters
        if ($data['apply_filters']) {

            //filters: id
            if (request()->filled('filter_ticket_id')) {
                $tickets->where('ticket_id', request('filter_ticket_id'));
            }
            //filter: date (start)
            if (request()->filled('filter_ticket_created_start')) {
                $tickets->whereDate('ticket_created', '>=', request('filter_ticket_created_start'));
            }

            //filter: date (end)
            if (request()->filled('filter_ticket_created_end')) {
                $tickets->whereDate('ticket_created', '<=', request('filter_ticket_created_end'));
            }

            //filter clients
            if (request()->filled('filter_ticket_clientid')) {
                $tickets->where('ticket_clientid', request('filter_ticket_clientid'));
            }

            //resource filtering
            if (request()->filled('ticketresource_type') && request()->filled('ticketresource_id')) {
                switch (request('ticketresource_type')) {
                case 'client':
                    $tickets->where('ticket_clientid', request('ticketresource_id'));
                    break;
                case 'project':
                    $tickets->where('ticket_projectid', request('ticketresource_id'));
                    break;
                }
            }

            //filter status
            if (is_array(request('filter_ticket_status')) && !empty(array_filter(request('filter_ticket_status')))) {
                $tickets->whereIn('ticket_status', request('filter_ticket_status'));
            }

            //filter priority
            if (is_array(request('filter_ticket_priority')) && !empty(array_filter(request('filter_ticket_priority')))) {
                $tickets->whereIn('ticket_priority', request('filter_ticket_priority'));
            }

            //filter category
            if (is_array(request('filter_ticket_categoryid')) && !empty(array_filter(request('filter_ticket_categoryid')))) {
                $tickets->whereIn('ticket_categoryid', request('filter_ticket_categoryid'));
            }

            //filter: tags
            if (is_array(request('filter_tags')) && !empty(request('filter_tags'))) {
                $tickets->whereHas('tags', function ($q) {
                    $q->whereIn('tag_title', request('filter_tags'));
                });
            }

        }

        //stats: - counting
        if (isset($data['stats']) && $data['stats'] == 'count-open') {
            $tickets->where('ticket_status', 'open');
        }
        if (isset($data['stats']) && $data['stats'] == 'count-closed') {
            $tickets->where('ticket_status', 'closed');
        }
        if (isset($data['stats']) && $data['stats'] == 'count-answered') {
            $tickets->where('ticket_status', 'answered');
        }

        //custom fields filtering
        if (request('action') == 'search') {
            if ($fields = \App\Models\CustomField::Where('customfields_type', 'tickets')->Where('customfields_show_filter_panel', 'yes')->get()) {
                foreach ($fields as $field) {
                    //field name, as posted by the filter panel (e.g. filter_ticket_custom_field_70)
                    $field_name = 'filter_' . $field->customfields_name;
                    if ($field->customfields_name != '' && request()->filled($field_name)) {
                        if (in_array($field->customfields_datatype, ['number', 'decimal', 'dropdown', 'date', 'checkbox'])) {
                            $tickets->Where($field->customfields_name, request($field_name));
                        }
                        if (in_array($field->customfields_datatype, ['text', 'paragraph'])) {
                            $tickets->Where($field->customfields_name, 'LIKE', '%' . request($field_name) . '%');
                        }
                    }
                }
            }
        }

        //search: various client columns and relationships (where first, then wherehas)
        if (request()->filled('search_query') || request()->filled('query')) {
            $tickets->where(function ($query) {
                $search_query = request('search_query') ?? request('query');

                // Ticket direct fields
                $query->where('ticket_id', '=', $search_query);
                $query->orWhere('ticket_created', 'LIKE', '%' . date('Y-m-d', strtotime($search_query)) . '%');
                $query->orWhere('ticket_subject', 'LIKE', '%' . $search_query . '%');
                $query->orWhere('ticket_message', 'LIKE', '%' . $search_query . '%');
                $query->orWhere('ticket_status', '=', $search_query);
                $query->orWhere('ticket_priority', '=', $search_query);
                $query->orWhere('ticket_source', '=', $search_query);
                $query->orWhere('ticket_imap_sender_email_address', 'LIKE', '%' . $search_query . '%');

                // Creator (submitter) - name and email
                $query->orWhere('users.first_name', 'LIKE', '%' . $search_query . '%');
                $query->orWhere('users.last_name', 'LIKE', '%' . $search_query . '%');
                $query->orWhere('users.email', 'LIKE', '%' . $search_query . '%');

                // Project name
                $query->orWhere('projects.project_title', 'LIKE', '%' . $search_query . '%');

                // Category name
                $query->orWhereHas('category', function ($q) use ($search_query) {
                    $q->where('category_name', 'LIKE', '%' . $search_query . '%');
                });

                // Client company name
                $query->orWhereHas('client', function ($q) use ($search_query) {
                    $q->where('client_company_name', 'LIKE', '%' . $search_query . '%');
                });

                // ticket replies
                $query->orWhereHas('replies', function ($q) use ($search_query) {
                    $q->where('ticketreply_text', 'LIKE', '%' . $search_query . '%');
                });

                // Tags
                $query->orWhereHas('tags', function ($q) use ($search_query) {
                    $q->where('tag_title', 'LIKE', '%' . $search_query . '%');
                });
            });
        }

        //sorting
        if (in_array(request('sortorder'), array('desc', 'asc')) && request('orderby') != '') {
            //direct column name
            if (Schema::hasColumn('tickets', request('orderby'))) {
                $tickets->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                    ->orderBy(request('orderby'), request('sortorder'));
            }
            //others
            switch (request('orderby')) {
            case 'client':
                $tickets->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                    ->orderBy('client_company_name', request('sortorder'));
                break;
            case 'category':
                $tickets->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                    ->orderBy('category_name', request('sortorder'));
                break;
            }
        } else {
            //default sorting
            $tickets->orderByRaw('CASE WHEN pinned.pinned_id IS NOT NULL THEN 1 ELSE 0 END DESC')
                ->orderBy('ticket_id', 'desc');
        }

        //default with array
        $with = [
            'attachments.creator',
            'tags',
            'replies',
        ];

        //ticket exports
        if (isset($data['with_replies']) && $data['with_replies'] === true) {
            $with[] = 'replies.creator';
        }

        //eager load entire width
        $tickets->with($with);

        //eager load counts
        $tickets->withCount([
            'attachments',
        ]);

        //stats - sum all
        if (isset($data['stats']) && in_array($data['stats'], [
            'count-all',
            'count-open',
            'count-closed',
            'count-answered',
        ])) {
            return $tickets->count();
        }

        //we are not paginating (e.g. when doing exports)
        if (isset($data['no_pagination']) && $data['no_pagination'] === true) {
            return $tickets->get();
        }

        // Get the results and return them.
        return $tickets->paginate(config('system.settings_system_pagination_limits'));
    }

    /**
     * Check if a department/category has IMAP enabled
     * Used to determine if tickets should automatically use IMAP email system
     *
     * @param int $category_id Category/Department ID
     * @return array|false Array with 'from_email' if enabled, false otherwise
     */
    public function checkImapEnabled($category_id) {

        // Get the category/department
        $category = \App\Models\Category::where('category_type', 'ticket')
            ->where('category_id', $category_id)
            ->first();

        if (!$category) {
            return false;
        }

        // Check if IMAP is enabled (category_meta_4) and has FROM email (category_meta_5)
        if ($category->category_meta_4 == 'enabled' && !empty($category->category_meta_5)) {
            return [
                'from_email' => $category->category_meta_5,
            ];
        }

        return false;
    }

    /**
     * Generate a unique Message-ID for email threading
     * Format: {unique_id}@{domain}
     * Used by email clients to maintain conversation threads
     *
     * @param string $from_email The FROM email address (used to extract domain)
     * @return string Generated Message-ID
     */
    public function generateMessageId($from_email) {

        // Extract domain from email address
        $from_domain = strrchr($from_email, '@');

        // Generate unique ID and append domain
        // Format: 123abc456def.78901234@example.com
        return uniqid('', true) . '@' . substr($from_domain, 1);
    }

    /**
     * Get the appropriate email address for a client ticket
     * Priority logic: ticket creator email > primary contact email
     *
     * @param int $client_id Client ID
     * @param int|null $creator_id Ticket creator user ID (optional)
     * @return string|null Email address or null if not found
     */
    public function getClientEmailForTicket($client_id, $creator_id = null) {

        // No client linked - cannot get email
        if (empty($client_id)) {
            return null;
        }

        // Priority 1: Try to get the ticket creator's email (if they are a client user)
        // This ensures the email goes to the person who created the ticket
        if ($creator_id) {
            $creator = \App\Models\User::where('id', $creator_id)
                ->where('type', 'client')
                ->where('clientid', $client_id)
                ->whereNotNull('email')
                ->where('email', '!=', '')
                ->first();

            if ($creator) {
                return $creator->email;
            }
        }

        // Priority 2: Fallback to the primary contact (account owner)
        // Used when ticket is created by team member or creator has no email
        $primary_contact = \App\Models\User::where('clientid', $client_id)
            ->where('type', 'client')
            ->where('account_owner', 'yes')
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->first();

        if ($primary_contact) {
            return $primary_contact->email;
        }

        // No valid email found - ticket will be created as web-based
        return null;
    }

    /**
     * Convert a web-based ticket to IMAP mode
     * This enables email-based replies for tickets originally created via the CRM
     * Typically triggered when team member replies to web ticket on IMAP-enabled department
     *
     * @param object $ticket Ticket model instance
     * @return bool True if conversion successful, false otherwise
     */
    public function convertToImapTicket($ticket) {

        // Validate ticket is web-based (can't convert IMAP ticket)
        if ($ticket->ticket_source != 'web') {
            return false;
        }

        // Check if IMAP is enabled on this department
        $imap_config = $this->checkImapEnabled($ticket->ticket_categoryid);
        if (!$imap_config) {
            return false;
        }

        // Get client email address using priority logic
        $client_email = $this->getClientEmailForTicket($ticket->ticket_clientid, $ticket->ticket_creatorid);

        if (empty($client_email)) {
            return false;
        }

        // Generate Message-ID for email threading
        // This becomes the root of the email conversation thread
        $message_id = $this->generateMessageId($imap_config['from_email']);

        // Update ticket to IMAP mode
        $ticket->ticket_source = 'email';
        $ticket->ticket_imap_sender_email_address = $client_email;
        $ticket->ticket_imap_sender_email_id = $message_id;
        $ticket->save();

        return true;
    }

    /**
     * Create a new record
     * @return mixed int|bool
     */
    public function create() {

        //save new user
        $ticket = new $this->tickets;

        //common fields
        $ticket->ticket_categoryid = request('ticket_categoryid');
        $ticket->ticket_creatorid = auth()->id();
        $ticket->ticket_subject = request('ticket_subject');
        $ticket->ticket_message = request('ticket_message');
        $ticket->ticket_priority = request('ticket_priority');

        /** -------------------------------------------------------------------------
         * [new user mode] - Manual ticket creation for new/unregistered users
         * Triggered by toggle link on ticket creation form
         * Creates user account if email doesn't exist in system
         *
         * Attribution: Ticket is attributed to the email recipient user
         * to match behavior of incoming IMAP tickets
         * -----------------------------------------------------------------------*/
        if (request('ticket_type') == 'email') {

            $email_address = request('ticket_email');
            $full_name = request('user_name');

            $ticket->ticket_source = 'email';
            $ticket->ticket_clientid = null;
            $ticket->ticket_projectid = null;
            $ticket->ticket_imap_sender_email_address = $email_address;

            // Generate Message-ID for email threading
            $category = \App\Models\Category::find(request('ticket_categoryid'));
            $from_email = $category->category_meta_5;
            $from_domain = strrchr($from_email, '@');
            $message_id = uniqid('', true) . '@' . substr($from_domain, 1);
            $ticket->ticket_imap_sender_email_id = $message_id;

            // Check if user exists with this email
            // Search for any user type (client or contact) with this email
            if ($user = \App\Models\User::where('email', $email_address)->first()) {

                // Existing user found - use their details
                $ticket->ticket_creatorid = $user->id;

                // If they're a client user, link to their client account
                if ($user->type == 'client' && !empty($user->clientid)) {
                    $ticket->ticket_clientid = $user->clientid;
                }

            } else {

                // User doesn't exist - create new contact user (like incoming IMAP tickets)
                // Split the full name into first_name and last_name
                $name_parts = explode(' ', trim($full_name), 2);
                $first_name = $name_parts[0];
                $last_name = isset($name_parts[1]) ? $name_parts[1] : '';

                // Create new user
                $user = new \App\Models\User();
                $user->type = 'contact';
                $user->creatorid = 0; // System created
                $user->email = $email_address;
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->save();

                // Set ticket creator to the newly created user
                $ticket->ticket_creatorid = $user->id;
                // ticket_clientid remains null for contact users
            }

        } else {
            /** -------------------------------------------------------------------------
             * [client mode] - Standard client-based ticket creation
             * Automatically uses IMAP if department has it enabled and client has email
             * Falls back to web-based if IMAP not available
             * -----------------------------------------------------------------------*/

            // Set client and project from request
            $ticket->ticket_clientid = request('ticket_clientid');
            $ticket->ticket_projectid = request('ticket_projectid');

            // Default to web-based ticket
            $ticket->ticket_source = 'web';

            // Check if we should automatically use IMAP for this ticket
            if (request('ticket_clientid')) {

                // Check if department has IMAP enabled
                $imap_config = $this->checkImapEnabled(request('ticket_categoryid'));

                if ($imap_config) {

                    // Get client email address (creator or primary contact)
                    $client_email = $this->getClientEmailForTicket(
                        request('ticket_clientid'),
                        auth()->id()
                    );

                    // If client has valid email, set up as IMAP ticket
                    if ($client_email) {
                        $ticket->ticket_source = 'email';
                        $ticket->ticket_imap_sender_email_address = $client_email;
                        $ticket->ticket_imap_sender_email_id = $this->generateMessageId($imap_config['from_email']);
                    }
                }
            }
        }

        //save and return id
        if ($ticket->save()) {

            //apply custom fields data
            $this->applyCustomFields($ticket->ticket_id);

            return $ticket->ticket_id;
        } else {
            return false;
        }
    }

    /**
     * update a record
     * @param int $id ticket id
     * @return bool
     */
    public function update($id) {

        //get the record
        if (!$ticket = $this->tickets->find($id)) {
            Log::error("record could not be found", ['process' => '[TicketRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__, 'ticket_id' => $id ?? '']);
            return false;
        }

        //general
        $ticket->ticket_categoryid = request('ticket_categoryid');
        $ticket->ticket_projectid = request('ticket_projectid');
        $ticket->ticket_subject = request('ticket_subject');
        $ticket->ticket_message = request('ticket_message');
        $ticket->ticket_priority = request('ticket_priority');
        $ticket->ticket_status = request('ticket_status');

        //save
        if ($ticket->save()) {

            //apply custom fields data
            $this->applyCustomFields($ticket->ticket_id);

            return $ticket->ticket_id;
        } else {
            Log::error("record could not be saved - database error", ['process' => '[TicketRepository]', config('app.debug_ref'), 'function' => __function__, 'file' => basename(__FILE__), 'line' => __line__, 'path' => __file__]);
            return false;
        }
    }

    /**
     * Get ticket history for a given creator, excluding the current ticket
     * @param int $creator_id  the user id of the ticket creator
     * @param int $exclude_ticket_id  the current ticket id to exclude
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getHistory($creator_id, $exclude_ticket_id) {

        $tickets = $this->tickets->newQuery();

        $tickets->leftJoin('tickets_status', 'tickets_status.ticketstatus_id', '=', 'tickets.ticket_status');

        $tickets->select('ticket_id', 'ticket_subject', 'ticket_created', 'ticketstatus_title', 'ticketstatus_color');

        $tickets->where('ticket_creatorid', $creator_id);
        $tickets->where('ticket_id', '!=', $exclude_ticket_id);

        $tickets->orderBy('ticket_created', 'desc');

        return $tickets->paginate(10);
    }

    /**
     * update model wit custom fields data (where enabled)
     */
    public function applyCustomFields($id = '') {

        //custom fields
        $fields = \App\Models\CustomField::Where('customfields_type', 'tickets')->get();
        foreach ($fields as $field) {
            if ($field->customfields_standard_form_status == 'enabled') {
                $field_name = $field->customfields_name;
                \App\Models\Ticket::where('ticket_id', $id)
                    ->update([
                        "$field_name" => request($field_name),
                    ]);
            }
        }
    }

}