<?php

use Illuminate\Support\Facades\Config;

return [
    'route' => 'assets',
    'debug' => Config::get('app.debug'),
    'folder' => base_path("resources/assets"),
];