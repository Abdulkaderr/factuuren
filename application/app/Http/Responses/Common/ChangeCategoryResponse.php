<?php

/** --------------------------------------------------------------------------------
 * This classes renders [common] responses for various controllers
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Common;

use Illuminate\Contracts\Support\Responsable;

class ChangeCategoryResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for invoices
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //fire event to allow modules to extend view data (for leads)
        if (isset($categories) && $categories->isNotEmpty() && $categories->first()->category_type == 'lead') {
            event(new \App\Events\Leads\Responses\LeadChangeCategory($request, $this->payload));
        }

        //fire event to allow modules to extend view data (for estimates)
        if (isset($categories) && $categories->isNotEmpty() && $categories->first()->category_type == 'estimate') {
            event(new \App\Events\Estimates\Responses\EstimateChangeCategory($request, $this->payload));
        }

        //fire event to allow modules to extend view data (for contracts)
        if (isset($categories) && $categories->isNotEmpty() && $categories->first()->category_type == 'contract') {
            event(new \App\Events\Contracts\Responses\ContractChangeCategory($request, $this->payload));
        }

        //fire event to allow modules to extend view data (for proposals)
        if (isset($categories) && $categories->isNotEmpty() && $categories->first()->category_type == 'proposal') {
            event(new \App\Events\Proposals\Responses\ProposalChangeCategory($request, $this->payload));
        }

        //fire event to allow modules to extend view data (for invoices)
        if (isset($categories) && $categories->isNotEmpty() && $categories->first()->category_type == 'invoice') {
            event(new \App\Events\Invoices\Responses\InvoiceChangeCategory($request, $this->payload));
        }

        //fire event to allow modules to extend view data (for expenses)
        if (isset($categories) && $categories->isNotEmpty() && $categories->first()->category_type == 'expense') {
            event(new \App\Events\Expenses\Responses\ExpenseChangeCategory($request, $this->payload));
        }

        //fire event to allow modules to extend view data (for items)
        if (isset($categories) && $categories->isNotEmpty() && $categories->first()->category_type == 'item') {
            event(new \App\Events\Items\Responses\ItemChangeCategory($request, $this->payload));
        }

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

        //render the form
        $html = view('misc/change-category', compact('categories'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#actionsModalBody',
            'action' => 'replace',
            'value' => $html,
        );

        //show modal invoiceter
        $jsondata['dom_visibility'][] = array('selector' => '#actionsModalFooter', 'action' => 'show');

        //ajax response
        return response()->json($jsondata);
    }
}
