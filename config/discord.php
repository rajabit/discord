<?php


return [
    /** Discord app */
    'app_id' => env('DISCORD_APP_ID'),
    'token' =>  env('DISCORD_TOKEN'),
    'public' =>  env('DISCORD_PUBLIC'),
    'client' =>  env('DISCORD_CLIENT'),
    'secret' => env('DISCORD_SECRET'),


    /** Webhook route settings */
    'routes' => true,
    'prefix' => 'discord',
    'oauth_url' => null,
    'oauth_redirect' => null,

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
     * It passes interaction request to your event like event(array $request)

     * @param job
     * It queues selected job with interaction request like job(array $request)
     *  
     * @param command 
     * It executes selected command with interaction type and command name like artisan:command --type=1 --command=ping
     * 
     * @param controller 
     * It passes discord request model to your own route 
     * 
     * example:
     * 
     'commands' => [
        'ping' => [
            'type' => 1,
            'guild_id' => null,
            'description' => 'Shows you the bot\'s heartbeats!',
            'event' => App\Events\PingEvent::class,
            'controller' => [App\Http\Controllers\DiscordController::class, 'ping'],
            'job' => App\Jobs\PingJob::class,
            'command' => ['discord:ping', '--type=type', '--name=data.name'], // if you need to pass request data
            'command' => 'discord:ping, // else
        ]
    ]
    **/
    
];
