<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\Payments\LabeledPrice;

/**
 * Represents the content of an invoice message to be sent as the result of an inline query.
 *
 * @link https://core.telegram.org/bots/api#inputinvoicemessagecontent
 *
 * @method $this title(string $string)                   Required. Product name, 1-32 characters
 * @method $this description(string $string)             Required. Product description, 1-255 characters
 * @method $this payload(string $string)                 Required. Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use for your internal processes.
 * @method $this providerToken(string $string)           Required. Payment provider token, obtained via Botfather
 * @method $this currency(string $string)                Required. Three-letter ISO 4217 currency code, see more on currencies
 * @method $this prices(LabeledPrice[] $labeledPrice)    Required. Price breakdown, a JSON-serialized list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus, etc.)
 * @method $this maxTipAmount(int $int)                  (Optional). The maximum accepted amount for tips in the smallest units of the currency (integer, not float/double). For example, for a maximum tip of US$1.45 pass max_tip_amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies). Defaults to 0
 * @method $this suggestedTipAmounts(int[] $int)         (Optional). A JSON-serialized array of suggested amounts of tip in the smallest units of the currency (integer, not float/double). At most 4 suggested tip amounts can be specified. The suggested tip amounts must be positive, passed in a strictly increased order and must not exceed max_tip_amount.
 * @method $this providerData(string $string)            (Optional). A JSON-serialized object for data about the invoice, which will be shared with the payment provider. A detailed description of the required fields should be provided by the payment provider.
 * @method $this photoUrl(string $string)                (Optional). URL of the product photo for the invoice. Can be a photo of the goods or a marketing image for a service. People like it better when they see what they are paying for.
 * @method $this photoSize(int $int)                     (Optional). Photo size
 * @method $this photoWidth(int $int)                    (Optional). Photo width
 * @method $this photoHeight(int $int)                   (Optional). Photo height
 * @method $this needName(bool $bool)                    (Optional). Pass True, if you require the user's full name to complete the order
 * @method $this needPhoneNumber(bool $bool)             (Optional). Pass True, if you require the user's phone number to complete the order
 * @method $this needEmail(bool $bool)                   (Optional). Pass True, if you require the user's email address to complete the order
 * @method $this needShippingAddress(bool $bool)         (Optional). Pass True, if you require the user's shipping address to complete the order
 * @method $this sendPhoneNumberToProvider(bool $bool)   (Optional). Pass True, if user's phone number should be sent to provider
 * @method $this sendEmailToProvider(bool $bool)         (Optional). Pass True, if user's email address should be sent to provider
 * @method $this isFlexible(bool $bool)                  (Optional). Pass True, if the final price depends on the shipping method
 */
class InputInvoiceMessageContent extends InputMessageContent
{
}
