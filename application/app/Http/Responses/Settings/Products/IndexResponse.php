<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the index process for product custom fields settings
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Settings\Products;

use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Render the view for product custom fields settings
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        // Extract payload
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        // Render blade view
        $html = view('pages/settings/sections/products/custom-fields', compact('page', 'fields'))->render();

        // Prepare JSON response
        $jsondata['dom_html'][] = array(
            'selector' => "#settings-wrapper",
            'action' => 'replace',
            'value' => $html
        );

        // Activate left menu (if dynamic load)
        if (request('url_type') == 'dynamic') {
            $jsondata['dom_attributes'][] = [
                'selector' => '#settings-menu-products',
                'attr' => 'aria-expanded',
                'value' => false,
            ];
            $jsondata['dom_action'][] = [
                'selector' => '#settings-menu-products',
                'action' => 'trigger',
                'value' => 'click',
            ];
            $jsondata['dom_classes'][] = [
                'selector' => '#settings-menu-products-custom-fields',
                'action' => 'add',
                'value' => 'active',
            ];
        }

        // Post-run functions
        $jsondata['postrun_functions'][] = [
            'value' => 'NXProductCustomFields',
        ];

        return response()->json($jsondata);
    }
}
