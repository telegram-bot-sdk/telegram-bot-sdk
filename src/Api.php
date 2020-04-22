<?php

namespace Telegram\Bot;

use BadMethodCallException;
use Illuminate\Support\Traits\Macroable;

/**
 * Class Api.
 *
 * @mixin Commands\CommandBus
 */
class Api
{
    use Macroable {
        __call as macroCall;
    }

    use Traits\Http;
    use Traits\CommandsHandler;
    use Traits\HasContainer;
    use Traits\HasUpdate;

    use Methods\Chat;
    use Methods\Commands;
    use Methods\EditMessage;
    use Methods\Game;
    use Methods\Get;
    use Methods\Location;
    use Methods\Message;
    use Methods\Passport;
    use Methods\Payments;
    use Methods\Query;
    use Methods\Stickers;
    use Methods\Update;

    /** @var string Version number of the Telegram Bot PHP SDK. */
    public const VERSION = '4.0.0';

    /**
     * Instantiates a new Telegram super-class object.
     *
     * @param string $token The Telegram Bot API Access Token.
     */
    public function __construct(string $token = null)
    {
        $this->setAccessToken($token);
    }

    /**
     * Magic method to process any dynamic method calls.
     *
     * @param $method
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $arguments);
        }

        if (method_exists($this, $method)) {
            return $this->{$method}(...$arguments);
        }

        if (in_array($method, ['getConnectTimeOut', 'getTimeOut', 'isAsyncRequest'])) {
            return $this->getClient()->{$method}();
        }

        if (in_array($method, ['setConnectTimeOut', 'setTimeOut', 'setAsyncRequest'])) {
            $this->getClient()->{$method}(...$arguments);

            return $this;
        }

        if (method_exists($this->getClient(), $method)) {
            return $this->getClient()->{$method}(...$arguments);
        }

        // If the method does not exist on the API, try the commandBus.
        if (preg_match('/^\w+Commands?/', $method, $matches)) {
            return $this->getCommandBus()->{$matches[0]}(...$arguments);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}
