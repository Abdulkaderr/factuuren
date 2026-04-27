<?php

/** --------------------------------------------------------------------------------
 * This class queues the initial outbound email for new IMAP-based client tickets
 * Only used when team members create tickets for clients on IMAP-enabled departments
 *
 * Flow:
 * 1. Team member creates ticket for client
 * 2. Repository automatically sets up IMAP fields (if department has IMAP enabled)
 * 3. Controller calls this mailer to queue the initial email
 * 4. Cron job processes the queue and sends email to client
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class TicketImapNew extends Mailable {
    use Queueable;

    /**
     * Ticket model instance
     */
    public $ticket;

    /**
     * Create a new message instance.
     *
     * @param object $ticket Ticket model instance
     * @return void
     */
    public function __construct($ticket) {
        $this->ticket = $ticket;
    }

    /**
     * Build the message and queue it for sending.
     *
     * Process:
     * 1. Validates ticket instance and required fields
     * 2. Adds IMAP parsing marker to email body
     * 3. Queues email in emailqueue table with type 'imap-ticket-new'
     * 4. Cron job (ImapTicketRepliesCron) processes and sends
     *
     * @return $this|false
     */
    public function build() {

        // Validate ticket is a proper model instance
        if (!$this->ticket instanceof \App\Models\Ticket) {
            return false;
        }

        // Validate required IMAP fields are populated
        // These should have been set by TicketRepository->create()
        if (empty($this->ticket->ticket_imap_sender_email_address)) {
            return false;
        }

        // Add marker for IMAP parsing (consistent with reply emails)
        // This marker is used by IMAP processing to extract only the new reply content
        // when client responds to the email
        $body = '<div class="nextloop-start-of-crm-reply"></div>' . $this->ticket->ticket_message;

        // Queue the email for processing by cron job
        // Type 'imap-ticket-new' is processed by ImapTicketRepliesCron
        $queue = new \App\Models\EmailQueue();
        $queue->emailqueue_to = $this->ticket->ticket_imap_sender_email_address;
        $queue->emailqueue_subject = $this->ticket->ticket_subject;
        $queue->emailqueue_message = $body;
        $queue->emailqueue_type = 'imap-ticket-new';
        $queue->emailqueue_resourcetype = 'ticket';
        $queue->emailqueue_resourceid = $this->ticket->ticket_id;
        $queue->save();
    }
}
