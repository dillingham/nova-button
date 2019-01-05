<?php

namespace NovaButton\Events;

use Illuminate\Foundation\Events\Dispatchable;

class Click
{
    use Dispatchable;

    public $resourceName;
    public $resourceId;
    public $buttonKey;

    public function __construct($resourceName, $resourceId, $buttonKey)
    {
        $this->resourceName = $resourceName;
        $this->resourceId = $resourceId;
        $this->buttonKey = $buttonKey;
    }
}
