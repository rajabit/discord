<?php

namespace Rajabit\Discord\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Discord\Interaction;
use Discord\InteractionResponseType;

class WebhookAuthenticateMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        /**
         * 
         * Validate discord interaction request
         * 
         */

        $CLIENT_PUBLIC_KEY = config('discord.public');

        $signature = $request->header('HTTP_X_SIGNATURE_ED25519');
        $timestamp = $request->header('HTTP_X_SIGNATURE_TIMESTAMP');
        $postData = file_get_contents('php://input');

        if (!Interaction::verifyKey(
            $postData,
            $signature,
            $timestamp,
            $CLIENT_PUBLIC_KEY
        )) {
            return abort(401);
        }

        return $next($request);
    }
}
