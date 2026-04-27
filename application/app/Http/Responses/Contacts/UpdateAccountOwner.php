<?php

/** --------------------------------------------------------------------------------
 * This class manages the response for updating the account owner
 *
 * @package    CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Contacts;

use Illuminate\Contracts\Support\Responsable;

class UpdateAccountOwner implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Render the response for updating account owner
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        // Set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        // Replace the new account owner row
        $html = view('pages/contacts/components/table/ajax', compact('contacts'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => "#contact_" . $contacts->first()->id,
            'action' => 'replace-with',
            'value' => $html,
        );

        // Replace the previous account owner row (if exists)
        if (isset($previous_owner_contacts) && $previous_owner_contacts) {
            $contacts = $previous_owner_contacts;
            $html = view('pages/contacts/components/table/ajax', compact('contacts'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => "#contact_" . $previous_owner_contacts->first()->id,
                'action' => 'replace-with',
                'value' => $html,
            );
        }

        // Success notification
        $jsondata['notification'] = array(
            'type' => 'success',
            'value' => __('lang.request_has_been_completed'),
        );

        return response()->json($jsondata);
    }
}
