<?php

namespace Rajabit\Discord\Http\Controllers;

use Illuminate\Http\Request;
use Discord\InteractionType;
use Discord\InteractionResponseType;
use Illuminate\Support\Facades\Storage;

class WebhookController
{

    public function index(Request $request)
    {
        /** answer to ping request */
        if ($request->input('type') == InteractionType::PING) {
            return response()->json(["type" => InteractionResponseType::PONG]);
        }

        return response()->json([
            "type" => InteractionResponseType::CHANNEL_MESSAGE_WITH_SOURCE,
            "data" => [
                "tts" => False,
                "content" => "Congrats on sending your command!",
                "embeds" => [],
                "allowed_mentions" => ["parse" => []]
            ]
        ]);
    }
}
