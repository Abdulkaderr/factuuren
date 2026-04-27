<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [show] process for the proposals
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Documents;

use Illuminate\Contracts\Support\Responsable;

class ShowEditResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
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

        //fire event for contract edit
        if (isset($document) && $document->doc_type == 'contract') {
            $view = 'pages/documents/editing/page';
            event(new \App\Events\Contracts\Responses\ContractEdit($request, $this->payload, $view));
        }

        //fire event for proposal edit
        if (isset($document) && $document->doc_type == 'proposal') {
            event(new \App\Events\Proposals\Responses\ProposalEdit($request, $this->payload));
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

        return view('pages/documents/editing/page', compact('page', 'document', 'payload', 'categories', 'customfields', 'estimate'))->render();
    }
}
