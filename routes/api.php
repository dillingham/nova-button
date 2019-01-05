<?php

Route::post(
    '/{resourceName}/{resourcceId}/{buttonKey}',
    'NovaButton\Http\Controllers\ButtonController@store'
);
