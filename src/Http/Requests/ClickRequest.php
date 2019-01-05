<?php

namespace NovaButton\Http\Requests;

use Laravel\Nova\Http\Requests\ResourceDetailRequest;

class ClickRequest extends ResourceDetailRequest
{
    public function resolvedResource()
    {
        return $this->newResourceWith(
            tap($request->findModelQuery(), function ($query) use ($request) {
                $request->newResource()->detailQuery($request, $query);
            })->firstOrFail()
        );
    }
}
