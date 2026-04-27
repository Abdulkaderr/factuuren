<?php

/** --------------------------------------------------------------------------------
 * This class queues the initial outbound email for direct email tickets
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

class TicketDirectEmail extends Mailable {
    use Queueable;

    public $ticket;

    /**
     * Create a new message instance.
     * @param object $ticket Ticket model instance
     * @return void
     */
    public function __construct($ticket) {
        $this->ticket = $ticket;
    }

    /**
     * Build the message and queue it.
     * @return $this
     */
    public function build() {

        // Validate ticket
        if (!$this->ticket instanceof \App\Models\Ticket) {
            return false;
        }

        // Add marker for IMAP parsing
        $body = '<div class="nextloop-start-of-crm-reply"></div>' . $this->ticket->ticket_message;

        // Queue the email
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
