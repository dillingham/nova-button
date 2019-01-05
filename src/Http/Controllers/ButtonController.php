<?php

namespace NovaButton\Http\Controllers;

use Illuminate\Routing\Controller;
use NovaButton\Http\Requests\ClickRequest;

class ButtonController extends Controller
{
    public function store(ClickRequest $request)
    {
        $resource = $request->resolvedResource();
        
        $event = $request->event;

        event(new $event($resource, $request->buttonKey));

        return response('', 200);
    }
}
