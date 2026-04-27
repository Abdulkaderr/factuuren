<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [update] process for the estimates
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Estimates;
use Illuminate\Contracts\Support\Responsable;

class UpdateTaxtypeResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for estimates
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        request()->session()->flash('success-notification-long', __('lang.request_has_been_completed'));

        $jsondata['redirect_url'] = url("/estimates/$bill_id/edit-estimate");

        //we are editing a proposal or contract pricing estimate
        if ($estimate->bill_estimate_type == 'document') {

            //contract
            if (is_numeric($estimate->bill_contractid)) {
                $jsondata['redirect_url'] = url("/contracts/" . $estimate->bill_contractid . "/edit");
                request()->session()->flash('success-notification', __('lang.request_has_been_completed'));
            }

            //contract
            if (is_numeric($estimate->bill_proposalid)) {
                $jsondata['redirect_url'] = url("/proposals/" . $estimate->bill_proposalid . "/edit");
                request()->session()->flash('success-notification', __('lang.request_has_been_completed'));
            }
        }

        //response
        return response()->json($jsondata);

    }

}
