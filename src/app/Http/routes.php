<?php

use Illuminate\Support\Facades\Config;

Route::group(['prefix' => Config::get('assets::app.route'), 'namespace' => 'Rdehnhardt\Assets\Http\Controllers'], function () {

    Route::match(['GET'], '/' . Config::get('assets::app.route') . '-{hash}.{type}', 'AssetsController@application');

    Route::get('{path}', 'AssetsController@file')->where('path', '.*');

});

Event::listen('check.file.cache', function ($File) {
    if (!Cache::has($File->filename)) {
        Cache::forever($File->filename, $File->getContent());
    }
});