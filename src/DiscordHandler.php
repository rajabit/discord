<?php

namespace Rajabit\Discord;

use Illuminate\Http\Client\Response;
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
        return "$this->baseUrl/$this->appId/$slug";
    }

    private function http(array $headers = [])
    {
        return Http::withHeaders([
            "Authorization" => "Bot $this->token",
            "Content-Type" => "application/json"
        ])->acceptJson();
    }

    public function makeGlobalCommand(array $array): Response
    {
        return $this->http()->post($this->url("commands"), $array);
    }

    public function makeGuildCommand(string $guild_id, array $array): Response
    {
        return $this->http()->post($this->url("commands"), $array);
    }
}
