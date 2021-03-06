<?php

return [
    /*
     * Enabling and disabling the use of the package.
     *
     * If the use of the package is turned off, accessing it will
     * always return a successful response, that is, a spammer was not found.
     *
     * There will also be no recording to the database - the facade will simply return "true".
     *
     * Default, true
     */

    'enabled' => env('BLACKLIST_ENABLED', true),

    /*
     * If you specify "local" in the value, then requests will be processed by the local server.
     */

    'server_url' => env('BLACKLIST_SERVER_URL'),

    /*
     * Float describing the timeout of the request in seconds.
     * Use "0" to wait indefinitely (the default behavior).
     */

    'server_timeout' => 0,

    /*
     * Default, false
     */

    'verify_ssl' => false,

    /*
     * If cors is configured on your server or you need to transfer some specific headers, fill in this option.
     */

    'headers' => [
        // 'Accept' => 'application/json',
    ],

    /*
     * The values shown here will not be blacklisted.
     *
     * By default, exceptions are added:
     *   127.0.0.1
     *   <ip-address of this server>
     *   <url of this server>
     *
     * Default, [].
     */

    'except' => [],
];
