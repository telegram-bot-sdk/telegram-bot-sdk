<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\AbstractObject;

/**
 * @link https://core.telegram.org/bots/api#personaldetails
 * @property string $first_name               First Name
 * @property string $last_name                Last Name
 * @property string $middle_name              (Optional). Middle Name
 * @property string $birth_date               Date of birth in DD.MM.YYYY format
 * @property string $gender                   Gender, male or female
 * @property string $country_code             Citizenship (ISO 3166-1 alpha-2 country code)
 * @property string $residence_country_code   Country of residence (ISO 3166-1 alpha-2 country code)
 * @property string $first_name_native        First Name in the language of the user's country of residence
 * @property string $last_name_native         Last Name in the language of the user's country of residence
 * @property string $middle_name_native       (Optional). Middle Name in the language of the user's country of residence
 */
class PersonalDetails extends AbstractObject
{
}
