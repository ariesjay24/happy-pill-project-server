<?php

return [

'default' => env('BROADCAST_DRIVER', 'log'),

'connections' => [

    'redis' => [
        'driver' => 'redis',
        'connection' => 'default',
    ],

    'log' => [
        'driver' => 'log',
    ],

    'null' => [
        'driver' => 'null',
    ],

],

];
