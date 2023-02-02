<?php

namespace Rajabit\Discord;

use Illuminate\Support\Facades\Http;

class DiscordHandler
{
    private $appId, $token, $public, $client,
        $baseUrl = "https://discord.com/api/v10/applications";

    public function __construct($appId, $token, $public, $client)
    {
        $this->appId = $appId;
        $this->token = $token;
        $this->public = $public;
        $this->client = $client;
    }

    public function url(string $slug = ""): string
    {
        return "$this->baseUrl/$this->appId/commands/$slug";
    }

    private function http(array $headers = [])
    {
        return Http::withToken($this->token)->acceptJson();
    }

    public function makeGlobalCommand(array $array)
    {
        return Http::withHeaders([
            'Authorization' => 'foo',
        ])->post($this->url("commands"), $array);
    }

    public function makeGuildCommand()
    {
    }
}
