<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [show] process for the proposals
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Documents;

use App\Repositories\ContractRepository;
use Illuminate\Contracts\Support\Responsable;

class ShowPreviewResponse implements Responsable {

    private $payload;
    protected $contractrepo;

    public function __construct($payload = array(), ContractRepository $contractrepo = null) {
        $this->payload = $payload;
        $this->contractrepo = $contractrepo ?: app(ContractRepository::class);
    }

    /**
     * render the view for team members
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        $payload = $this->payload;

        //fire event for contract show
        if (isset($document) && $document->doc_type == 'contract') {
            $view = 'pages/documents/preview/page';
            event(new \App\Events\Contracts\Responses\ContractShow($request, $this->payload, $view));
        }

        //fire event for proposal show
        if (isset($document) && $document->doc_type == 'proposal') {
            if (isset($view) && $view == 'showPublic') {
                event(new \App\Events\Proposals\Responses\ProposalShowPublic($request, $this->payload));
            } else {
                event(new \App\Events\Proposals\Responses\ProposalShow($request, $this->payload));
            }
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

        //print-mode
        if (request('render') == 'print') {
            config(['visibility.page_rendering' => 'print-page']);
        } else {
            config(['visibility.page_rendering' => 'view']);
        }

        //generate the estimate
        if ($has_estimate) {
            $rendered_estimate = view('pages/bill/bill-embed', compact('page', 'bill', 'taxrates', 'taxes', 'elements', 'units', 'lineitems', 'customfields', 'estimate'))->render();
        }

        //render the page
        $final_document = view('pages/documents/preview/page', compact('page', 'document', 'payload', 'customfields', 'estimate'))->render();

        //add estimate
        if ($has_estimate) {
            $final_document = str_replace('{pricing_table}', $rendered_estimate, $final_document);
        } else {
            $final_document = str_replace('{pricing_table}', '', $final_document);
        }

        //replace pricing total for proposals
        if ($document->doc_type == 'proposal') {
            $final_document = str_replace('{pricing_total}', runtimeMoneyFormat($bill->bill_final_amount), $final_document);
        }

        //replace pricing table total for contracts
        if ($document->doc_type == 'contract') {
            $final_document = str_replace('{pricing_table_total}', runtimeMoneyFormat($bill->bill_final_amount), $final_document);
        }

        //replace all standard and custom field variables using repository method
        $final_document = $this->contractrepo->replaceVariables($final_document, $document);

        //show page
        return $final_document;
    }
}
