<?php

Route::post(
    '/{resource}/{resourceId}/{buttonKey}',
    'NovaButton\Http\Controllers\ButtonController@handle'
);
