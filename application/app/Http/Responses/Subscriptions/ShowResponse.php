<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [create] process for the subscription
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Subscriptions;

use Illuminate\Contracts\Support\Responsable;

class ShowResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for subscription members
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //fire event
        $view = 'pages/subscription/wrapper';
        event(new \App\Events\Subscriptions\Responses\SubscriptionShow($request, $this->payload, $view));

        //[events] process module injections - push content to blade stacks
        if (isset($this->payload['module_injections'])) {
            foreach ($this->payload['module_injections'] as $injection) {
                try {
                    view()->startPush($injection['stack']);
                    echo $injection['content'];
                    view()->stopPush();
                } catch (Exception $e) {
                    //nothing
                }
            }
        }

        //load more button - change the page number and determine buttons visibility
        if ($invoices->currentPage() < $invoices->lastPage()) {
            $page['url'] = url("/subscriptions/$subscription_id/invoices?page=2");
            $page['load_more_visibility'] = 'visible';
        } else {
            $page['load_more_visibility'] = 'hidden';
        }

        return view('pages/subscription/wrapper', compact('page', 'subscription', 'invoices', 'interval'))->render();
    }
}
