<?php

namespace Rajabit\Discord;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Illuminate\Http\Client\Response makeGlobalCommand(array $array)
 * @method static Illuminate\Http\Client\Response makeGuildCommand(string $guild_id, array $array)
 * @method static Illuminate\Http\Client\Response createInteractionResponse(string|int $interaction_id, string $interaction_token, array $data)
 */
class Discord extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Discord';
    }
}
