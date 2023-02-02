<?php

namespace Rajabit\Discord\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebhookAuthenticateMiddleware
{

    public function handle(Request $request, Closure $next)
    {


        return $next($request);
    }
}
