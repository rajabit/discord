<?php

namespace Rajabit\Discord\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Rajabit\Discord\InteractionResponseType;
use Rajabit\Discord\InteractionType;

class WebhookController
{

    public function index(Request $request)
    {

        $array = [
            "schemeAndHttpHost" => $request->schemeAndHttpHost(),
            "method" => $request->method(),
            "body" => $request->all(),
            "headers" => $request->header()
        ];

        Storage::disk('local')
            ->put('discord.log', json_encode($array, JSON_PRETTY_PRINT) . "\n\n");

        return response()->json([
            "type" => InteractionResponseType::CHANNEL_MESSAGE_WITH_SOURCE,
            "data" => [
                "content" => 'Hello world',
            ]
        ]);
    }
}
