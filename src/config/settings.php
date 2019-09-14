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
     *
     * Set "null" to use our server.
     *
     * Default, null
     */

    'server_url' => env('BLACKLIST_SERVER_URL'),

    /*
     * Float describing the timeout of the request in seconds.
     * Use "0" to wait indefinitely (the default behavior).
     */

    'server_timeout' => 0,

    /*
     * If you using Let's Encrypt certificates, then set this value to "false".
     *
     * Default, true
     */

    'verify_ssl' => false,

    /*
     * If cors is configured on your server or you need to transfer some specific headers, fill in this option.
     */
    'headers' => [
        // 'Content-Type" => 'application/json'
    ]

];
