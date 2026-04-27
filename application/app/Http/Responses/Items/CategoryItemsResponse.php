<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [edit] process for the fooo
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Items;

use Illuminate\Contracts\Support\Responsable;

class CategoryItemsResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for fooo members
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
        event(new \App\Events\Items\Responses\ItemCategoryItems($request, $this->payload));

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
        $html = view('pages/items/components/modals/category-items', compact('categories'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#categoryItemsModalBody',
            'action' => 'replace',
            'value' => $html,
        );

        $jsondata['skip_checkboxes_reset'] = true;

        $jsondata['skip_dom_reset'] = true;

        $jsondata['skip_dom_tinymce'] = true;

        //ajax response
        return response()->json($jsondata);
    }
}
