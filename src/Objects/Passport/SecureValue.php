<?php

namespace Telegram\Bot\Objects\Passport;

/**
 * @link https://core.telegram.org/bots/api#securevalue
 *
 * @property DataCredentials   $data          (Optional). Credentials for encrypted Telegram Passport data. Available for “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport” and “address” types.
 * @property FileCredentials   $frontSide     (Optional). Credentials for an encrypted document's front side. Available for “passport”, “driver_license”, “identity_card” and “internal_passport”.
 * @property FileCredentials   $reverseSide   (Optional). Credentials for an encrypted document's reverse side. Available for “driver_license” and “identity_card”.
 * @property FileCredentials   $selfie        (Optional). Credentials for an encrypted selfie of the user with a document. Available for “passport”, “driver_license”, “identity_card” and “internal_passport”.
 * @property FileCredentials[] $translation   (Optional). Credentials for an encrypted translation of the document. Available for “passport”, “driver_license”, “identity_card”, “internal_passport”, “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration”.
 * @property FileCredentials[] $files         (Optional). Credentials for encrypted files. Available for “utility_bill”, “bank_statement”, “rental_agreement”, “passport_registration” and “temporary_registration” types.
 */
class SecureValue
{
}
