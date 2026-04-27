<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [change status] process for invoices
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Invoices;
use Illuminate\Contracts\Support\Responsable;

class ChangeStatusResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view or process response
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //show form
        if ($response == 'show-form') {

            //render the form
            $html = view('pages/invoices/components/modals/change-status', compact('page', 'statuses', 'invoice'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#actionsModalBody',
                'action' => 'replace',
                'value' => $html);

            //show modal footer
            $jsondata['dom_visibility'][] = array('selector' => '#actionsModalFooter', 'action' => 'show');

            //ajax response
            return response()->json($jsondata);
        }

        //show bulk form
        if ($response == 'show-bulk-form') {

            //render the bulk form
            $html = view('pages/invoices/components/modals/bulk-change-status', compact('statuses'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#actionsModalBody',
                'action' => 'replace',
                'value' => $html);

            //show modal footer
            $jsondata['dom_visibility'][] = array('selector' => '#actionsModalFooter', 'action' => 'show');

            //ajax response
            return response()->json($jsondata);
        }

        //update status
        if ($response == 'update-status') {

            //close modal
            $jsondata['dom_visibility'][] = array('selector' => '#commonModal', 'action' => 'close-modal');

            //notice
            $jsondata['notification'] = array('type' => 'success', 'value' => __('lang.request_has_been_completed'));

            //reload page
            $jsondata['redirect_url'] = request()->server('HTTP_REFERER');

            //response
            return response()->json($jsondata);
        }

    }

}
