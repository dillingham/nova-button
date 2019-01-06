<?php

namespace NovaButton\Events;

use Illuminate\Foundation\Events\Dispatchable;

class ButtonClick
{
    use Dispatchable;

    public $resource;
    public $key;

    public function __construct($resource, $key)
    {
        $this->resource = $resource;
        $this->key = $key;
    }
}
