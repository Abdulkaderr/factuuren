<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [store reply] process for the tickets
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Tickets;
use Illuminate\Contracts\Support\Responsable;

class StoreReplyResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for tickets
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //branch based on the on-reply setting
        if (isset($settings) && $settings->settings2_tickets_on_reply == 'stay-on-page') {

            //stay on ticket page — redirect back to the ticket so the new reply is visible
            $jsondata['redirect_url'] = url('/tickets/' . $ticket->ticket_id);
            request()->session()->flash('success-notification', __('lang.request_has_been_completed'));

        } else {

            //default: return-to-list — redirect with session flash
            $jsondata['redirect_url'] = url('/tickets');
            request()->session()->flash('success-notification', __('lang.request_has_been_completed'));

        }

        //response
        return response()->json($jsondata);

    }

}
