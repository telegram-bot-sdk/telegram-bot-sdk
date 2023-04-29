<?php

namespace Telegram\Bot\Methods;

trait Passport
{
    /**
     * Set Passport Data Errors.
     *
     * Informs a user that some of the Telegram Passport elements they provided contains errors. The user will not be able to re-submit their Passport to you until the errors are fixed (the contents of the field for which you returned the error must change). Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#setpassportdataerrors
     *
     * @param array{
     * 	user_id: int,
     * 	errors: array,
     * } $params
     */
    public function setPassportDataErrors(array $params): bool
    {
        return $this->post('setPassportDataErrors', $params)->getResult();
    }
}
