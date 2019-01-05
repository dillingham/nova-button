<?php

namespace NovaButton\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Nova\Http\Requests\NovaRequest;

class ButtonController extends Controller
{
    public function handle(NovaRequest $request)
    {
        $event = $request->event;

        $resource = $request->findModelQuery()->firstOrFail();

        event(new $event($resource, $request->buttonKey));

        return response('', 200);
    }
}
