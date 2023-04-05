<?php

namespace Telegram\Bot;

use Illuminate\Support\Traits\Macroable;
use Telegram\Bot\Exceptions\TelegramLoginAuthException;
use Telegram\Bot\Methods\Chat;
use Telegram\Bot\Methods\Commands;
use Telegram\Bot\Methods\EditMessage;
use Telegram\Bot\Methods\Game;
use Telegram\Bot\Methods\Get;
use Telegram\Bot\Methods\Location;
use Telegram\Bot\Methods\Message;
use Telegram\Bot\Methods\Passport;
use Telegram\Bot\Methods\Payments;
use Telegram\Bot\Methods\Query;
use Telegram\Bot\Methods\Stickers;
use Telegram\Bot\Methods\Update;
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
        __call as macroCall;

    }
    use Http;
    use HasToken;
    use Chat;
    use Commands;
    use EditMessage;
    use Game;
    use Get;
    use Location;
    use Message;
    use Passport;
    use Payments;
    use Query;
    use Stickers;
    use Update;

    /**
     * Instantiates a new Telegram super-class object.
     *
     * @param  string|null  $token  The Telegram Bot Token.
     */
    public function __construct(string $token = null)
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
