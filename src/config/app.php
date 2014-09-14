<?php

return [

    'name' => 'assets',

    'debug' => true,

    'route' => [
        'namespace' => 'Rdehnhardt\Assets\Http',
        'prefix' => 'assets',
    ],

    'folder' => [
        'default' => base_path('resources'),
        'map' => 'map.php',
    ],

    'providers' => [
        'Laracasts\Commander\CommanderServiceProvider'
    ]

];