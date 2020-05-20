<?php

namespace Telegram\Bot;

use BadMethodCallException;
use Illuminate\Support\Traits\Macroable;
use Telegram\Bot\Exceptions\TelegramLoginAuthException;

/**
 * Class Api.
 */
class Api
{
    use Macroable {
        __call as macroCall;
    }

    use Traits\Http;
    use Traits\HasAccessToken;

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

    /**
     * Instantiates a new Telegram super-class object.
     *
     * @param string $token The Telegram Bot API Access Token.
     */
    public function __construct(string $token = null)
    {
        $this->accessToken = $token;
    }

    /**
     * Determine given login auth data is valid.
     *
     * @param array $auth_data
     *
     * @throws TelegramLoginAuthException
     *
     * @return array
     */
    public function isLoginAuthDataValid(array $auth_data): array
    {
        if (!isset($auth_data['hash'])) {
            throw TelegramLoginAuthException::hashNotFound();
        }

        $check_hash = $auth_data['hash'];

        $data_check_string = collect($auth_data)
            ->only(['username', 'auth_date', 'first_name', 'last_name', 'photo_url', 'id'])
            ->map(fn ($value, $key) => $key . '=' . $value)
            ->sort()
            ->implode("\n");

        $secret_key = hash('sha256', $this->accessToken, true);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);

        if (!hash_equals($hash, $check_hash)) {
            throw TelegramLoginAuthException::dataNotFromTelegram();
        }

        if ((time() - $auth_data['auth_date']) > 86400) {
            throw TelegramLoginAuthException::dataOutdated();
        }

        return $auth_data;
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

        if (in_array($method, ['getConnectTimeout', 'getTimeout', 'isAsyncRequest'])) {
            return $this->getClient()->{$method}();
        }

        if (in_array($method, ['setConnectTimeout', 'setTimeout', 'setAsyncRequest'])) {
            $this->getClient()->{$method}(...$arguments);

            return $this;
        }

        if (method_exists($this->getClient(), $method)) {
            return $this->getClient()->{$method}(...$arguments);
        }

        throw new BadMethodCallException("Method [$method] does not exist.");
    }
}
