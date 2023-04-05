<?php

namespace Telegram\Bot\Methods;

trait Passport
{
    /**
     * Set Passport Data Errors.
     *
     * <code>
     * $params = [
     *      'user_id'     => '',  // int                    - Required. User identifier
     *      'errors'      => '',  // PassportElementError[] - Required. A JSON-serialized array describing the errors
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setpassportdataerrors
     *
     * @param array $params
     */
    public function setPassportDataErrors(array $params): bool
    {
        return $this->post('setPassportDataErrors', $params)->getResult();
    }
}
