<?php

namespace Rajabit\Discord;

enum InteractionType: int
{
    /**
     * A ping.
     */
    case PING = 1;
    /**
     * A command invocation.
     */
    case APPLICATION_COMMAND = 2;
    /**
     * Usage of a message's component.
     */
    case MESSAGE_COMPONENT = 3;
    /**
     * An interaction sent when an application command option is filled out.
     */
    case APPLICATION_COMMAND_AUTOCOMPLETE = 4;
    /**
     * An interaction sent when a modal is submitted.
     */
    case MODAL_SUBMIT = 5;
}

enum InteractionResponseType: int
{
    /**
     * Acknowledge a `PING`.
     */
    case  PONG = 1;
    /**
     * Respond with a message, showing the user's input.
     */
    case  CHANNEL_MESSAGE_WITH_SOURCE = 4;
    /**
     * Acknowledge a command without sending a message, showing the user's input. Requires follow-up.
     */
    case  DEFERRED_CHANNEL_MESSAGE_WITH_SOURCE = 5;
    /**
     * Acknowledge an interaction and edit the original message that contains the component later; the user does not see a loading state.
     */
    case DEFERRED_UPDATE_MESSAGE = 6;
    /**
     * Edit the message the component was attached to.
     */
    case  UPDATE_MESSAGE = 7;
        /*
     * Callback for an app to define the results to the user.
     */
    case APPLICATION_COMMAND_AUTOCOMPLETE_RESULT = 8;
        /*
     * Respond with a modal.
     */
    case MODAL = 9;
}


enum MessageComponentTypes: int
{
    case  ACTION_ROW = 1;
    case  BUTTON = 2;
    case  STRING_SELECT = 3;
    case  INPUT_TEXT = 4;
    case  USER_SELECT = 5;
    case  ROLE_SELECT = 6;
    case  MENTIONABLE_SELECT = 7;
    case  CHANNEL_SELECT = 8;
}


enum ButtonStyleTypes: int
{
    case PRIMARY = 1;
    case SECONDARY = 2;
    case SUCCESS = 3;
    case DANGER = 4;
    case LINK = 5;
}


enum ChannelTypes: int
{
    case  DM = 1;
    case  GROUP_DM = 3;
    case  GUILD_TEXT = 0;
    case  GUILD_VOICE = 2;
    case  GUILD_CATEGORY = 4;
    case  GUILD_ANNOUNCEMENT = 5;
    case  GUILD_STORE = 6;
}

enum TextStyleTypes: int
{
    case SHORT = 1;
    case  PARAGRAPH = 2;
}
