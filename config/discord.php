<?php

return [
    /** Discord app */
    'app_id' => env('DISCORD_APP_ID'),
    'token' =>  env('DISCORD_TOKEN'),
    'public' =>  env('DISCORD_PUBLIC'),
    'client' =>  env('DISCORD_CLIENT'),


    /** Webhook route settings */
    'routes' => true,
    'prefix' => 'discord'
];
