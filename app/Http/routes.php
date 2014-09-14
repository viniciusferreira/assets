<?php

Route::group(
    ['prefix' => 'assets', 'namespace' => 'Assets\Http'],
    function () {
        Route::get('{path}', 'AssetsController@file')->where('path', '.*');
    }
);