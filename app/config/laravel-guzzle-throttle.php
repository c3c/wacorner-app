<?php

// @codeCoverageIgnoreStart

// example configuration
return [
    'cache' => [
        // Name of the configured driver in the Laravel cache config file / Also needs to be set when "no-cache" is set! Because it's used for the internal timers
        'driver'      => \env('CACHE_DRIVER'),
        // Cache strategy: no-cache, cache, force-cache
        'strategy'    => 'cache',
        // TTL in minutes
        'ttl'         => 900,
        // When this is set to false, empty responses won't be cached.
        'allow_empty' => true
    ],
    'rules' => [
        // host (including scheme)
        'https://api.totalcorner.com' => [
            [
                // maximum number of requests in the given interval
                'max_requests'     => 30,
                // interval in seconds till the limit is reset
                'request_interval' => 60
            ],
        ]
    ]
];

// @codeCoverageIgnoreEnd
