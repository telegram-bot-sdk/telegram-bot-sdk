<?php

namespace Telegram\Bot\Methods;

trait Passport
{
    /**
     * Set Passport Data Errors.
     *
     * @param array{
     * 	user_id: int,
     * 	errors: PassportElementError[],
     * } $params
     *
     * @link https://core.telegram.org/bots/api#setpassportdataerrors
     */
    public function setPassportDataErrors(array $params): bool
    {
        return $this->post('setPassportDataErrors', $params)->getResult();
    }
}
