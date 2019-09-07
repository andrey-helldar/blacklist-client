<?php

return [

    /*
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

];
