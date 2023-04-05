<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\AbstractResponseObject;

/**
 * @link https://core.telegram.org/bots/api#securedata
 *
 * @property SecureValue $personal_details            (Optional). Credentials for encrypted personal details
 * @property SecureValue $passport                    (Optional). Credentials for encrypted passport
 * @property SecureValue $internal_passport           (Optional). Credentials for encrypted internal passport
 * @property SecureValue $driver_license              (Optional). Credentials for encrypted driver license
 * @property SecureValue $identity_card               (Optional). Credentials for encrypted ID card
 * @property SecureValue $address                     (Optional). Credentials for encrypted residential address
 * @property SecureValue $utility_bill                (Optional). Credentials for encrypted utility bill
 * @property SecureValue $bank_statement              (Optional). Credentials for encrypted bank statement
 * @property SecureValue $rental_agreement            (Optional). Credentials for encrypted rental agreement
 * @property SecureValue $passport_registration       (Optional). Credentials for encrypted registration from internal passport
 * @property SecureValue $temporary_registration      (Optional). Credentials for encrypted temporary registration
 */
class SecureData extends AbstractResponseObject
{
    /**
     * @return array{personal_details: class-string<\Telegram\Bot\Objects\Passport\SecureValue>, passport: class-string<\Telegram\Bot\Objects\Passport\SecureValue>, internal_passport: class-string<\Telegram\Bot\Objects\Passport\SecureValue>, driver_license: class-string<\Telegram\Bot\Objects\Passport\SecureValue>, identity_card: class-string<\Telegram\Bot\Objects\Passport\SecureValue>, address: class-string<\Telegram\Bot\Objects\Passport\SecureValue>, utility_bill: class-string<\Telegram\Bot\Objects\Passport\SecureValue>, bank_statement: class-string<\Telegram\Bot\Objects\Passport\SecureValue>, rental_agreement: class-string<\Telegram\Bot\Objects\Passport\SecureValue>, passport_registration: class-string<\Telegram\Bot\Objects\Passport\SecureValue>, temporary_registration: class-string<\Telegram\Bot\Objects\Passport\SecureValue>}
     */
    public function relations(): array
    {
        return [
            'personal_details'       => SecureValue::class,
            'passport'               => SecureValue::class,
            'internal_passport'      => SecureValue::class,
            'driver_license'         => SecureValue::class,
            'identity_card'          => SecureValue::class,
            'address'                => SecureValue::class,
            'utility_bill'           => SecureValue::class,
            'bank_statement'         => SecureValue::class,
            'rental_agreement'       => SecureValue::class,
            'passport_registration'  => SecureValue::class,
            'temporary_registration' => SecureValue::class,
        ];
    }
}
