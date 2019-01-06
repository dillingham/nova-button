<?php

namespace NovaButton\Events;

use Illuminate\Foundation\Events\Dispatchable;

class Click
{
    use Dispatchable;

    public $resource;
    public $buttonKey;

    public function __construct($resource, $buttonKey)
    {
        $this->resource = $resource;
        $this->buttonKey = $buttonKey;
    }
}
