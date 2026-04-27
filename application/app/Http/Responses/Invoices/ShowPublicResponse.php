<?php

namespace App\Http\Responses\Invoices;

use Illuminate\Contracts\Support\Responsable;

class ShowPublicResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    public function toResponse($request) {

        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        $view = 'pages/bill/wrapper-public';
        event(new \App\Events\Invoices\Responses\InvoiceShow($request, $this->payload));

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

        config([
            'visibility.bill_mode' => 'viewing',
            'visibility.public_bill_viewing' => true,
            'visibility.bill_files_section' => true,
            'visibility.tax_type_selector' => true,
            'bill.render_mode' => 'web',
        ]);

        return view($view, compact('page', 'bill', 'taxrates', 'taxes', 'elements', 'units', 'lineitems', 'customfields', 'files'))->render();
    }
}
