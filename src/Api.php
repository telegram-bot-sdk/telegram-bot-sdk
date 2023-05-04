<?php

namespace Telegram\Bot;

use Illuminate\Support\Traits\Macroable;
use Telegram\Bot\Exceptions\TelegramLoginAuthException;
use Telegram\Bot\Methods\Games;
use Telegram\Bot\Methods\GettingUpdates;
use Telegram\Bot\Methods\InlineMode;
use Telegram\Bot\Methods\Methods;
use Telegram\Bot\Methods\Passport;
use Telegram\Bot\Methods\Payments;
use Telegram\Bot\Methods\Stickers;
use Telegram\Bot\Methods\UpdateMessages;
use Telegram\Bot\Traits\ForwardsCalls;
use Telegram\Bot\Traits\HasToken;
use Telegram\Bot\Traits\Http;

/**
 * Class Api.
 */
class Api
{
    use ForwardsCalls;
    use Macroable {
        Macroable::__call as macroCall;
    }
    use Http;
    use HasToken;
    use GettingUpdates;
    use Methods;
    use UpdateMessages;
    use InlineMode;
    use Stickers;
    use Payments;
    use Passport;
    use Games;

    /**
     * Instantiates a new Telegram super-class object.
     *
     * @param  string  $token  The Telegram Bot Token.
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * Determine given login auth data is valid.
     *
     *
     * @throws TelegramLoginAuthException
     */
    public function isLoginAuthDataValid(array $auth_data): array
    {
        if (! isset($auth_data['hash'])) {
            throw TelegramLoginAuthException::hashNotFound();
        }

        $check_hash = $auth_data['hash'];

        $data_check_string = collect($auth_data)
            ->only(['username', 'auth_date', 'first_name', 'last_name', 'photo_url', 'id'])
            ->map(fn ($value, $key): string => $key.'='.$value)
            ->sort()
            ->implode("\n");

        $secret_key = hash('sha256', $this->token, true);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);

        if (! hash_equals($hash, $check_hash)) {
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
