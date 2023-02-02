<?php

namespace Rajabit\Discord;

use Illuminate\Support\ServiceProvider;
use Rajabit\Discord\Discord;

class DiscordServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //
    }

    public function register()
    {

        $this->app->singleton(Discord::class, function ($app) {
            return new Discord(
                $this->app['config']->get('DISCORD_APP_ID'),
                $this->app['config']->get('DISCORD_TOKEN'),
                $this->app['config']->get('DISCORD_PUBLIC'),
                $this->app['config']->get('DISCORD_CLIENT')
            );
        });
    }
}
