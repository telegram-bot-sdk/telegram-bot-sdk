<?php

namespace Telegram\Bot\Objects\InlineQuery;

use Telegram\Bot\Objects\AbstractCreateObject;
use Telegram\Bot\Objects\WebApp\WebAppInfo;

/**
 * Represents a button to be shown above inline query results. You must use exactly one of the optional fields.
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultsbutton
 *
 * @method $this text(string $text) Label text on the button
 * @method $this webApp(WebAppInfo $webAppInfo) (Optional). Description of the Web App that will be launched when the user presses the button. The Web App will be able to switch back to the inline mode using the method switchInlineQuery inside the Web App.
 * @method $this startParameter(string $startParameter) (Optional). Deep-linking parameter for the /start message sent to the bot when a user presses the button. 1-64 characters, only A-Z, a-z, 0-9, _ and - are allowed.
 */
final class InlineQueryResultsButton extends AbstractCreateObject {}
