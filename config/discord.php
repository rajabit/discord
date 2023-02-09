<?php

return [
    /** Discord app */
    'app_id' => env('DISCORD_APP_ID'),
    'token' =>  env('DISCORD_TOKEN'),
    'public' =>  env('DISCORD_PUBLIC'),
    'client' =>  env('DISCORD_CLIENT'),


    /** Webhook route settings */
    'routes' => true,
    'prefix' => 'discord',

    /** 
     ** Define command list
     ** Make a new command, like here we have the ping command
     *
     * @param type:
     * You can make `Global Command` or `Guild Command`
     * Type 1 if you want the `Global Command` and 2 for the `Guild Command`
     * Documentation:
     * https://discord.com/developers/docs/interactions/application-commands#registering-a-command
     * 
     * @param guild_id
     * If it's a `Guild Command` you must input guild_id, 
     * leave it empty if it's a global command
     * 
     * @param description
     * Command description shows when a user types the command
     * `Guild Command` can not have a description
     * 
     ** Keys down below are the interaction events, 
     ** You can use anyone you want or use multiple together.
     * 
     * @param event
     * It passes interaction type and data to your event like event(string $type, array $data)
     * 
     * @param controller 
     * It passes discord request model to your own route 
     * 
     * @param job
     * It queues selected job with interaction type and data to your event like job(string $type, array $data)
     *  
     * @param command 
     * It executes selected command with interaction type and command name like artisan:command --type=1 --command=ping
     */
    'commands' => [
        'ping' => [
            'type' => 1,
            'guild_id' => null,
            'description' => 'Shows you the bot\'s heartbeats!',
            'event' => null,
            'controller' => null,
            'job' => null,
            'command' => null
        ]
    ]
];
