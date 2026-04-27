<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [show] process for the leads
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Http\Responses\Leads;

use Illuminate\Contracts\Support\Responsable;

class contentResponse implements Responsable {

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

        //full payload array
        $payload = $this->payload;

        /** -------------------------------------------------------------------------
         * show main lead tab (home)
         * -------------------------------------------------------------------------*/
        if ($type == 'show-main') {

            //fire event to allow modules to extend view data
            event(new \App\Events\Leads\Responses\LeadShowMain($request, $this->payload));

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

            // LEFT PANEL - MAIN (code is copied from ShowResponse)
            $html = view('pages/lead/leftpanel', compact('page', 'lead', 'progress', 'attachment_tags'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#card-leads-left-panel',
                'action' => 'replace',
                'value' => $html,
            );

            // LEFT PANEL - COMMENTS (code is copied from ShowResponse)
            $html = view('pages/lead/components/comment', compact('comments'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#card-comments-container',
                'action' => 'replace',
                'value' => $html,
            );

            // LEFT PANEL - ATTACHMENTS (code is copied from ShowResponse)
            $html = view('pages/lead/components/attachment', compact('attachments'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#card-attachments-container',
                'action' => 'replace',
                'value' => $html,
            );

            // LEFT PANEL - CHECKLIST (code is copied from ShowResponse)
            $html = view('pages/lead/components/checklist', compact('checklists', 'progress'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#card-checklists-container',
                'action' => 'replace',
                'value' => $html,
            );

            //  LEFT PANEL - PROGRESS (code is copied from ShowResponse)
            $html = view('pages/lead/components/progressbar', compact('progress'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => '#card-checklist-progress-container',
                'action' => 'replace',
                'value' => $html,
            );

            // POSTRUN FUNCTIONS------
            $jsondata['postrun_functions'][] = [
                'value' => 'NXLeadAttachFiles',
            ];

            // POSTRUN FUNCTIONS------
            $jsondata['postrun_functions'][] = [
                'value' => 'NXBootCards',
            ];
        }

        /** -------------------------------------------------------------------------
         * show organisation tab
         * -------------------------------------------------------------------------*/
        if ($type == 'show-organisation') {

            //fire event to allow modules to extend view data
            event(new \App\Events\Leads\Responses\LeadShowOrganisation($request, $this->payload));

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

            $html = view('pages/lead/content/organisation/show', compact('lead'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#card-leads-left-panel',
                'action' => 'replace',
                'value' => $html,
            ];
        }

        /** -------------------------------------------------------------------------
         * show organisation tab
         * -------------------------------------------------------------------------*/
        if (isset($update_table) && $update_table == true) {
            $html = view('pages/leads/components/table/ajax', compact('leads'))->render();
            $jsondata['dom_html'][] = array(
                'selector' => "#lead_" . $leads->first()->lead_id,
                'action' => 'replace-with',
                'value' => $html,
            );
        }

        /** -------------------------------------------------------------------------
         * show edit - organisation tab
         * -------------------------------------------------------------------------*/
        if ($type == 'edit-organisation') {

            //fire event to allow modules to extend view data
            event(new \App\Events\Leads\Responses\LeadEditOrganisation($request, $this->payload));

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

            $html = view('pages/lead/content/organisation/edit', compact('lead'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#card-leads-left-panel',
                'action' => 'replace',
                'value' => $html,
            ];
        }

        /** -------------------------------------------------------------------------
         * show custom fields tab
         * -------------------------------------------------------------------------*/
        if ($type == 'show-custom-fields') {

            //fire event to allow modules to extend view data
            event(new \App\Events\Leads\Responses\LeadShowCustomFields($request, $this->payload));

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

            $html = view('pages/lead/content/customfields/show', compact('lead', 'fields'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#card-leads-left-panel',
                'action' => 'replace',
                'value' => $html,
            ];
        }

        /** -------------------------------------------------------------------------
         * edit custom fields tab
         * -------------------------------------------------------------------------*/
        if ($type == 'edit-custom-fields') {

            //fire event to allow modules to extend view data
            event(new \App\Events\Leads\Responses\LeadEditCustomFields($request, $this->payload));

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

            $html = view('pages/lead/content/customfields/edit', compact('lead', 'fields'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#card-leads-left-panel',
                'action' => 'replace',
                'value' => $html,
            ];
        }

        /** -------------------------------------------------------------------------
         * show user notes
         * -------------------------------------------------------------------------*/
        if ($type == 'show-notes') {

            //fire event to allow modules to extend view data
            event(new \App\Events\Leads\Responses\LeadShowMyNotes($request, $this->payload));

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

            $html = view('pages/lead/content/mynotes/show', compact('lead', 'note', 'has_note'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#card-leads-left-panel',
                'action' => 'replace',
                'value' => $html,
            ];
        }

        /** -------------------------------------------------------------------------
         * show user notes
         * -------------------------------------------------------------------------*/
        if ($type == 'edit-notes' || $type == 'create-notes') {

            //fire event to allow modules to extend view data
            if ($type == 'edit-notes') {
                event(new \App\Events\Leads\Responses\LeadEditMyNotes($request, $this->payload));
            } else {
                event(new \App\Events\Leads\Responses\LeadCreateMyNotes($request, $this->payload));
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

            $html = view('pages/lead/content/mynotes/edit', compact('lead', 'note'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#card-leads-left-panel',
                'action' => 'replace',
                'value' => $html,
            ];
        }

        /** -------------------------------------------------------------------------
         * show lead logs
         * -------------------------------------------------------------------------*/
        if ($type == 'show-logs') {

            //fire event to allow modules to extend view data
            event(new \App\Events\Leads\Responses\LeadShowLogs($request, $this->payload));

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

            $html = view('pages/lead/content/log/show', compact('logs'))->render();
            $jsondata['dom_html'][] = [
                'selector' => '#card-leads-left-panel',
                'action' => 'replace',
                'value' => $html,
            ];
        }

        //ajax response
        return response()->json($jsondata);
    }
}
