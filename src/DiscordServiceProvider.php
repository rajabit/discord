<?php

namespace Rajabit\Discord;

use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Rajabit\Http\Controllers\WebhookController;
use Rajabit\Discord\Http\Middleware\WebhookAuthenticateMiddleware;

class DiscordServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if (!app()->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__ . '/../config/discord.php', 'discord');
        }
    }

    public function register()
    {
        if (app()->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/discord.php' => config_path('discord.php'),
            ], 'discord-config');
        }

        $this->app->singleton('Discord', function ($app) {
            return new DiscordHandler(
                config('discord.app_id'),
                config('discord.token'),
                config('discord.public'),
                config('discord.client')
            );
        });

        $this->app->alias(Discord::class, 'Discord');


        $this->defineRoutes();
        $this->configureMiddleware();
    }

    protected function defineRoutes()
    {
        if (app()->routesAreCached() || config('discord.routes') === false) {
            return;
        }

        Route::group(['prefix' => config('discord.prefix', 'discord')], function () {
            Route::get(
                '/webhook',
                WebhookController::class . '@index'
            )->middleware(WebhookAuthenticateMiddleware::class)
                ->name('discord.webhook');
        });
    }

    /**
     * Configure the Sanctum middleware and priority.
     *
     * @return void
     */
    protected function configureMiddleware()
    {
        $kernel = app()->make(Kernel::class);

        $kernel->prependToMiddlewarePriority(AcceptLanguageMiddleware::class);
    }
}
