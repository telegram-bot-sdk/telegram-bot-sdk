<?php

namespace Telegram\Bot\Objects\MenuButton;

/**
 * Represents a menu button, which launches a Web App.
 *
 * @link https://core.telegram.org/bots/api#menubuttonwebapp
 *
 * @method $this text(string $string)  Text on the button
 * @method $this webApp($webAppInfo)   Description of the Web App that will be launched when the user presses the button. The Web App will be able to send an arbitrary message on behalf of the user using the method answerWebAppQuery.
 */
final class MenuButtonWebApp extends MenuButton
{
    protected string $type = 'web_app';
}
