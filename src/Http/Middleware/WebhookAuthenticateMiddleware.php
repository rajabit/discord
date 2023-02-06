<?php

namespace Rajabit\Discord\Http\Middleware;

use Closure;
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

        $signature = $request->header('X-Signature-Ed25519');
        $timestamp = $request->header('X-Signature-Timestamp');

        if (empty($signature) || empty($timestamp))
            return abort(401);


        if (!trim($signature, '0..9A..Fa..f') == '') {
            return abort(401);
        }

        $message = $timestamp . $request->getContent();
        $binary_signature = sodium_hex2bin($signature);
        $binary_key = sodium_hex2bin(config('discord.public'));

        if (!sodium_crypto_sign_verify_detached(
            $binary_signature,
            $message,
            $binary_key
        )) {
            return abort(401);
        }

        return $next($request);
    }
}
