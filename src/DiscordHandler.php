<?php

namespace Rajabit\Discord;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class DiscordHandler
{
    private $appId, $token, $public, $client,
        $baseUrl = "https://discord.com/api/v10";

    public function __construct($appId, $token, $public, $client)
    {
        $this->appId = $appId;
        $this->token = $token;
        $this->public = $public;
        $this->client = $client;
    }

    public function url(string $slug = ""): string
    {
        return "$this->baseUrl/$slug";
    }

    private function http(array $headers = [])
    {
        return Http::withHeaders([
            "Authorization" => "Bot $this->token",
            "Content-Type" => "application/json"
        ])->acceptJson();
    }

    /**
     * 
     * Global commands have inherent read-repair functionality. 
     * That means that if you make an update to a global command, 
     * and a user tries to use that command before it has updated for them, 
     * Discord will do an internal version check and reject the command, 
     * and trigger a reload for that command.
     * 
     * @param array $array
     * 
     * @return Illuminate\Http\Client\Response
     */
    public function makeGlobalCommand(array $array): Response
    {
        return $this->http()->post($this->url("applications/$this->appId/commands"), $array);
    }

    /**
     * 
     * Global commands have inherent read-repair functionality. 
     * That means that if you make an update to a global command, 
     * and a user tries to use that command before it has updated for them, 
     * Discord will do an internal version check and reject the command, 
     * and trigger a reload for that command.
     * 
     * @param string $guild_id
     * @param array $array
     * 
     * @return Illuminate\Http\Client\Response
     */
    public function makeGuildCommand(string $guild_id, array $array): Response
    {
        return $this->http()->post($this->url("applications/$this->appId/commands"), $array);
    }

    /**
     * Create a response to an Interaction from the gateway. 
     * Body is an interaction response. Returns 204 No Content.
     * 
     * @param string|int $interaction_id
     * @param string $interaction_token
     * @param array $data
     * 
     * @return Illuminate\Http\Client\Response
     */
    public function createInteractionResponse(
        string|int $interaction_id,
        string $interaction_token,
        array $data
    ): Response {
        return $this->http()
            ->post($this->url("interactions/$interaction_id/$interaction_token/callback"), $data);
    }

    /**
     * Returns the initial Interaction response. 
     * Functions the same as Get Webhook Message.
     * 
     * @param string|int $interaction_id
     * @param string $interaction_token
     * @param string $message_id
     * 
     * @return Illuminate\Http\Client\Response
     */
    public function getOriginalInteractionResponse(
        string|int $interaction_id,
        string $interaction_token,
        string $message_id
    ): Response {
        return $this->http()
            ->get($this->url("webhooks/$interaction_id/$interaction_token/messages/$message_id"));
    }

    /**
     * Edits the initial Interaction response. 
     * Functions the same as Edit Webhook Message.
     * 
     * @param string|int $interaction_id
     * @param string $interaction_token
     * @param string $message_id
     * @param array $data
     * 
     * @return Illuminate\Http\Client\Response
     */
    public function editOriginalInteractionResponse(
        string|int $interaction_id,
        string $interaction_token,
        string $message_id,
        array $data
    ): Response {
        return $this->http()
            ->patch($this->url("webhooks/$interaction_id/$interaction_token/messages/$message_id"), $data);
    }

    /**
     * Exchange oauth code with access token
     * 
     * @param string $code
     * 
     * @return Illuminate\Http\Client\Response
     */
    public function exchangeAccessToken(string $code, string $grant_type = "authorization_code"): Response
    {
        return Http::asForm()->post($this->url("oauth2/token"), [
            'client_id' => config('discord.app_id'),
            'client_secret' => config('discord.secret'),
            'grant_type' => $grant_type,
            'code' => $code,
            'redirect_uri' => config('discord.oauth_redirect')
        ]);
    }

    public function getMe(string $token, string $token_type = "Bearer")
    {
        return Http::withHeaders([
            "Authorization" => "$token_type $token",
            "Content-Type" => "application/json"
        ])->acceptJson()->get($this->url("oauth2/@me"));
    }
}
