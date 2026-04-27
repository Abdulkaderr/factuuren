<?php

/** --------------------------------------------------------------------------------
 * @GrowEvent
 * @GrowEventCategory Items
 * @GrowEventTiming pre-render
 * @GrowEventDescription Fired when item edit view is being rendered
 * @GrowEventPayload array &$payload View data passed by reference
 * @GrowEventBladeStack form_item_add_edit_main
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Items\Responses;

use Illuminate\Queue\SerializesModels;

class ItemEdit {

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