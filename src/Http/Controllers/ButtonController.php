<?php

namespace NovaButton\Http\Controllers;

use Illuminate\Routing\Controller;

class ButtonController extends Controller
{
    public function store($resourceName, $resourceId, $buttonKey)
    {
        $event = request('event');

        (new $event($resourceName, $resourceId, $buttonKey))->dispatch();

        return response('', 200);
    }
}
