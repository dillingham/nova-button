<?php

namespace NovaButton\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Nova\Http\Requests\ResourceDetailRequest;

class ButtonController extends Controller
{
    public function store(ResourceDetailRequest $request, $resourceName, $resourceId, $buttonKey)
    {
        $event = request('event');

        $resource = $request->newResourceWith(tap($request->findModelQuery(), function ($query) use ($request) {
            $request->newResource()->detailQuery($request, $query);
        })->firstOrFail());

        event(new $event($resource, $buttonKey));

        // event(new $event($resourceName, $resourceId, $buttonKey));

        return response('', 200);
    }
}
