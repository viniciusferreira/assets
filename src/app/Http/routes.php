<?php

Route::group(
    ['prefix' => 'assets', 'namespace' => 'Rdehnhardt\Assets\Http\Controllers'],
    function () {
        Route::get('{path}', 'AssetsController@file')->where('path', '.*');
    }
);

Event::listen('check.file.cache', function ($File) {
    if (!Cache::has($File->filename)) {
        Cache::forever($File->filename, $File->getContent());
    }
});