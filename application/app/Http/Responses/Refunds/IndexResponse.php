<?php

/** --------------------------------------------------------------------------------
 * This class renders the response for the [index] process for the Refunds controller
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Refunds;

use Illuminate\Contracts\Support\Responsable;

class IndexResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * Render the refunds list — supports ajax/embedded and standard page loading
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //unpack payload into local variables
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //ajax/embedded request handling
        if (request('source') == 'ext' || request('action') == 'search' || request()->ajax()) {

            //determine which template and DOM target to use
            switch (request('action')) {

            //load more button
            case 'load':
                $template      = 'pages/refunds/components/table/ajax';
                $dom_container = '#refunds-td-container';
                $dom_action    = 'append';
                break;

            //sort links
            case 'sort':
                $template      = 'pages/refunds/components/table/ajax';
                $dom_container = '#refunds-td-container';
                $dom_action    = 'replace';
                break;

            //search box or filter panel
            case 'search':
                $template      = 'pages/refunds/components/table/table';
                $dom_container = '#refunds-table-wrapper';
                $dom_action    = 'replace-with';
                break;

            //initial embedded/ajax load
            default:
                $template      = 'pages/refunds/tabswrapper';
                $dom_container = '#embed-content-container';
                $dom_action    = 'replace';
                break;
            }

            //load more button — update URL and toggle visibility
            if ($refunds->currentPage() < $refunds->lastPage()) {
                $url = loadMoreButtonUrl($refunds->currentPage() + 1, request('source'));
                $jsondata['dom_attributes'][] = array(
                    'selector' => '#load-more-button',
                    'attr'     => 'data-url',
                    'value'    => $url);
                $jsondata['dom_visibility'][] = array('selector' => '.loadmore-button-container', 'action' => 'show');
                $page['visibility_show_load_more'] = true;
                $page['url'] = $url;
            } else {
                $jsondata['dom_visibility'][] = array('selector' => '.loadmore-button-container', 'action' => 'hide');
            }

            //flip sorting url for this particular link - only when sort links are clicked
            if (request('action') == 'sort') {
                $sort_url = flipSortingUrl(request()->fullUrl(), request('sortorder'));
                $element_id = '#sort_' . request('orderby');
                $jsondata['dom_attributes'][] = array(
                    'selector' => $element_id,
                    'attr'     => 'data-url',
                    'value'    => $sort_url);
            }

            //render template into DOM
            $html = view($template, compact('page', 'refunds', 'tags'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => $dom_container,
                'action'   => $dom_action,
                'value'    => $html);

            return response()->json($jsondata);

        } else {
            //standard full-page view
            $page['url'] = loadMoreButtonUrl($refunds->currentPage() + 1, request('source'));
            $page['loading_target'] = 'refunds-td-container';
            $page['visibility_show_load_more'] = ($refunds->currentPage() < $refunds->lastPage()) ? true : false;
            return view('pages/refunds/wrapper', compact('page', 'refunds', 'tags'))->render();
        }
    }
}
