<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [pdf] process for the estimates
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Estimates;
use Illuminate\Contracts\Support\Responsable;
use PDF;

class PDFResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //so the event will know its PDF
        config(['response.pdf-estimate' => true]);

        //set view template
        $this->payload['blade'] = 'pages/bill/bill-pdf';

        //fire event
        event(new \App\Events\Estimates\Responses\EstimateShow($request, $this->payload));

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

        //how payload
        $payload = $this->payload;

        //[debugging purposes] view estimate in browser (https://domain.com/estimate/1/pdf?view=preview)
        if (request('view') == 'preview') {
            config([
                'css.bill_mode' => 'pdf-mode-preview',
                'bill.render_mode' => 'web',
            ]);
            return view($this->payload['blade'], compact('page', 'bill', 'taxrates', 'taxes', 'lineitems', 'elements', 'customfields', 'files', 'payload'))->render();
        }

        //visibility render mode & css mode
        config([
            'css.bill_mode' => 'pdf-mode-download',
            'bill.render_mode' => 'web',
        ]);

        //render the bill
        $pdf = PDF::loadView($this->payload['blade'], compact('page', 'bill', 'taxrates', 'taxes', 'lineitems', 'elements', 'customfields', 'files', 'payload'));
        $filename = strtoupper(__('lang.estimate')) . '-' . $bill->formatted_bill_estimateid . '.pdf'; //estate_inv0001.pdf
        return $pdf->download($filename);
    }
}
