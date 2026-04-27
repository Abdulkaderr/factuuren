<?php

/** --------------------------------------------------------------------------------
 * @GrowEvent
 * @GrowEventCategory Reports
 * @GrowEventTiming pre-render
 * @GrowEventDescription Fired when the main reports page view is being rendered
 * @GrowEventPayload array &$payload View data passed by reference
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Reports\Responses;

use Illuminate\Queue\SerializesModels;

class ReportShow {

    use SerializesModels;

    /**
     * The payload data for the view
     * @var array
     */
    public $payload;

    /**
     * Create a new event instance.
     * @param array &$payload View data passed by reference
     */
    public function __construct(&$payload) {
        $this->payload = &$payload;
    }
}