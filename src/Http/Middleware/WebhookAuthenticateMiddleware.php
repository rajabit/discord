<?php

namespace Rajabit\Discord\Http\Middleware;

use Closure;
use Discord\Interaction;
use Illuminate\Http\Request;

class WebhookAuthenticateMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        /**
         * 
         * Validate discord interaction request
         * 
         */
        if (!Interaction::verifyKey(
            $request->getContent(),
            $request->header('x-signature-ed25519'),
            $request->header('x-signature-timestamp'),
            config('discord.public')
        )) {
            return abort(401);
        }

        return $next($request);
    }
}
