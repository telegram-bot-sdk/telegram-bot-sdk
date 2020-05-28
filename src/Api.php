<?php

namespace Telegram\Bot;

use Illuminate\Support\Traits\Macroable;
use Telegram\Bot\Exceptions\TelegramLoginAuthException;
use Telegram\Bot\Traits\ForwardsCalls;

/**
 * Class Api.
 */
class Api
{
    use ForwardsCalls;
    use Macroable {
        __call as macroCall;
    }

    use Traits\Http;
    use Traits\HasToken;

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
     * @param string $token The Telegram Bot Token.
     */
    public function __construct(string $token = null)
    {
        $this->token = $token;
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

        $secret_key = hash('sha256', $this->token, true);
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
     * @param $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        return $this->forwardCallTo($this->getClient(), $method, $parameters);
    }
}
