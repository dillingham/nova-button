<?php

namespace NovaButton\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ButtonController extends Controller
{
    public function store($resourceName, $resourceId, $buttonKey)
    {
        (new $eventName($resourceName, $resourceId, $buttonKey))->dispatch();

        return 'ok';
    }
}
