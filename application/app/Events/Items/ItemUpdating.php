<?php

/** --------------------------------------------------------------------------------
 * @GrowEvent
 * @GrowEventCategory Items
 * @GrowEventTiming pre-storage
 * @GrowEventDescription Fired after core validation but before item update
 * @GrowEventPayload array $request_data, array $validated_input, object $item
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Items;

use Illuminate\Queue\SerializesModels;

class ItemUpdating {

    use SerializesModels;

    /**
     * The request data
     * @var array
     */
    public $request_data;

    /**
     * The validated input data
     * @var array
     */
    public $validated_input;

    /**
     * The existing item being updated
     * @var object
     */
    public $item;

    /**
     * Create a new event instance.
     * @param array $request_data All request data
     * @param array $validated_input Validated form data
     * @param object $item The existing item being updated
     */
    public function __construct($request_data, $validated_input, $item) {
        $this->request_data = $request_data;
        $this->validated_input = $validated_input;
        $this->item = $item;
    }
}