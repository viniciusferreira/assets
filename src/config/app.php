<?php

use Illuminate\Support\Facades\Config;

return [
    'route' => 'assets',
    'explode' => false,
    'debug' => Config::get('app.debug'),
    'folder' => base_path("resources/assets"),
];