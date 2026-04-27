<?php

/** --------------------------------------------------------------------------------
 * @GrowEvent
 * @GrowEventCategory Items
 * @GrowEventTiming pre-storage
 * @GrowEventDescription Fired after core validation but before item creation/update
 * @GrowEventPayload array $request_data, array $validated_input
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Items;

use Illuminate\Queue\SerializesModels;

class ItemStoring {

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
     * Create a new event instance.
     * @param array $request_data All request data
     * @param array $validated_input Validated form data
     */
    public function __construct($request_data, $validated_input) {
        $this->request_data = $request_data;
        $this->validated_input = $validated_input;
    }
}