<?php

namespace Rajabit\Discord\Http\Controllers;

use Illuminate\Http\Request;
use Rajabit\Discord\Discord;

class AuthenticateController
{
    public function oauth(Request $request)
    {
        $user = $request->user();

        abort_if(empty($user), 401, "Unauthenticated");

        $res = Discord::exchangeAccessToken($request->input('code'));

        abort_if(!$res->successful(), 401, $res['error_description'] ?? '');

        $user->discord_access_token = $res['access_token'];
        $user->discord_expires_in = now()->addSeconds($res['expires_in']);
        $user->discord_refresh_token = $res['refresh_token'];
        $user->save();

        $me = Discord::getMe($user->discord_access_token);

        abort_if(!$me->successful(), 401, $me['error_description'] ?? '');

        $user->discord_verified = $res->successful() && $me->successful();
        $user->discord_id = $me['user']['id'];
        $user->discord_username = $me['user']['username'];
        $user->discord_discriminator = $me['user']['discriminator'];
        $user->discord_avatar = $me['user']['avatar'];
        $user->save();

        return response()->json($user);
    }
}
