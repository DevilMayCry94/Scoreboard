<?php

return [
    'game_memcached' => [
        'ip' => env('GAME_MEMCACHED_IP') ?? '127.0.0.1',
        'port' => env('GAME_MEMCACHED_PORT') ?? 11211,
    ],
    'game_id_memcached' => [
        'ip' => env('GAME_ID_MEMCACHED_IP') ?? '127.0.0.1',
        'port' => env('GAME_ID_MEMCACHED_PORT') ?? 11212,
    ],
];
