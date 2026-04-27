<?php

namespace App\Events\Items;

/**
 * @GrowEvent
 * @GrowEventCategory Items
 * @GrowEventTiming pre-deletion
 * @GrowEventDescription Fired when an item is about to be deleted
 * @GrowEventPayload object $item The item being deleted
 */
class ItemDeleting {
    
    public $item;
    
    /**
     * Create a new event instance.
     *
     * @param object $item The item being deleted
     * @return void
     */
    public function __construct($item) {
        $this->item = $item;
    }
}
