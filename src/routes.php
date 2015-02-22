<?php

Route::get('wiki/{url?}', [
    'as'   => 'wiki.show',
    'uses' => 'WikiController@show',
])->where('url', '.+');