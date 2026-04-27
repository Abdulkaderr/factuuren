<?php

/** --------------------------------------------------------------------------------
 * Renders the Ajax response for the error logs tab on the customer profile.
 * Handles both the initial table render and load-more pagination appending.
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Landlord\Customer;

use Illuminate\Contracts\Support\Responsable;

class ErrorLogsResponse implements Responsable {

    private $payload;

    public function __construct($payload = []) {
        $this->payload = $payload;
    }

    /**
     * Build and return the Ajax JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //unpack payload into local variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //choose template and DOM target based on the action
        switch (request('action')) {

        //load more button - append rows to existing table body
        case 'load':
            $template = 'landlord/customer/errorlogs/ajax';
            $dom_container = '#error-logs-td-container';
            $dom_action = 'append';
            break;

        //default - replace the table wrapper with a fresh table render
        default:
            $template = 'landlord/customer/errorlogs/table';
            $dom_container = '#error-logs-table-wrapper';
            $dom_action = 'replace';
            break;
        }

        //load more button: update url and toggle visibility
        if ($logs->currentPage() < $logs->lastPage()) {
            $url = loadMoreButtonUrl($logs->currentPage() + 1, request('source'));
            $jsondata['dom_attributes'][] = [
                'selector' => '#load-more-button',
                'attr' => 'data-url',
                'value' => $url,
            ];
            $jsondata['dom_visibility'][] = ['selector' => '.loadmore-button-container', 'action' => 'show'];
            $page['visibility_show_load_more'] = true;
            $page['url'] = $url;
        } else {
            $jsondata['dom_visibility'][] = ['selector' => '.loadmore-button-container', 'action' => 'hide'];
        }

        //set the loading target for the load more button
        $page['loading_target'] = 'error-logs-td-container';

        //show delete all button
        $jsondata['dom_visibility'][] = [
            'selector' => '#error-logs-delete-all-button',
            'action' => 'show',
        ];

        //render and inject html
        $html = view($template, compact('page', 'logs', 'customer'))->render();
        $jsondata['dom_html'][] = [
            'selector' => $dom_container,
            'action' => $dom_action,
            'value' => $html,
        ];

        return response()->json($jsondata);
    }
}
