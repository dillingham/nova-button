<?php

Route::post(
    '/{resource}/{resourceId}/{buttonKey}',
    'NovaButton\Http\Controllers\ButtonController@store'
);
