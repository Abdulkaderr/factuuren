<?php

/** --------------------------------------------------------------------------------
 * @GrowEvent
 * @GrowEventCategory Items
 * @GrowEventTiming post-storage
 * @GrowEventDescription Fired after successful item creation/update
 * @GrowEventPayload int $item_id, object $item, array $request_data
 *
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace App\Events\Items;

use Illuminate\Queue\SerializesModels;

class ItemStored {

    use SerializesModels;

    /**
     * The item ID
     * @var int
     */
    public $item_id;

    /**
     * The item model instance
     * @var object
     */
    public $item;

    /**
     * The original request data
     * @var array
     */
    public $request_data;

    /**
     * Create a new event instance.
     * @param int $item_id The created/updated item ID
     * @param object $item The item model instance
     * @param array $request_data Original request data
     */
    public function __construct($item_id, $item, $request_data) {
        $this->item_id = $item_id;
        $this->item = $item;
        $this->request_data = $request_data;
    }
}