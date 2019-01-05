<?php

namespace NovaButton\Http\Controllers;

use Illuminate\Routing\Controller;

class ButtonController extends Controller
{
    public function store($resourceName, $resourceId, $buttonKey)
    {
        $event = request('event');

        event(new $event($resourceName, $resourceId, $buttonKey));

        return response('', 200);
    }
}
