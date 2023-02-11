<?php

namespace Rajabit\Discord\Http\Controllers;

use Illuminate\Http\Request;
use Discord\InteractionType;
use Discord\InteractionResponseType;
use Illuminate\Support\Facades\Artisan;

class WebhookController
{

    public function index(Request $request)
    {
        /** answer to ping request */
        if ($request->input('type') == InteractionType::PING) {
            return response()->json(["type" => InteractionResponseType::PONG]);
        }

        $conf = config("discord.commands")[$request->input('data.name')];

        $this->callEvent($conf, $request);
        $this->callJob($conf, $request);
        $this->callCommand($conf, $request);
        $data = $this->callController($conf, $request);

        return response()->json([
            "type" => InteractionResponseType::CHANNEL_MESSAGE_WITH_SOURCE,
            "data" => $data
        ]);
    }

    private function callController(array $conf, Request $request)
    {
        if (empty($conf['controller']))  return null;
        $controller = $conf['controller'];
        $method = $controller[1];
        return app($controller[0])->$method($request);
    }

    private function callCommand(array $conf, Request $request): void
    {
        if (empty($conf['command'])) return;
        $command = $conf['command'];

        if (is_string($command))
            Artisan::call($command);

        if (is_array($command) and count($command) > 0) {
            $opt = [];
            for ($i = 1; $i < count($command); $i++) {
                $sp = explode("=", $command[$i], 2);
                $opt[$sp[0]] = $request->input($sp[1], null);
            }
            Artisan::call($command[0], $opt);
        }
    }

    private function callJob(array $conf, Request $request): void
    {
        if (empty($conf['job'])) return;

        dispatch(new $conf['job']($request->all()));
    }

    private function callEvent(array $conf, Request $request): void
    {
        if (empty($conf['event'])) return;

        event(new $conf['event']($request->all()));
    }
}
