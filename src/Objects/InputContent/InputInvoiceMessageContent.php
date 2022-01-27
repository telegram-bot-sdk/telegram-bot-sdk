<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\AbstractCreateObject;

/**
 * Class InputInvoiceMessageContent.
 *
 * Represents the content of an invoice message to be sent as the result of an inline query.
 *
 * <code>
 * [
 *   'title'                         => '',  //  string          - Required. Product name, 1-32 characters
 *   'description'                   => '',  //  string          - Required. Product description, 1-255 characters
 *   'payload'                       => '',  //  string          - Required. Bot-defined invoice payload, 1-128 bytes. This will not be displayed to the user, use for your internal processes.
 *   'provider_token'                => '',  //  string          - Required. Payment provider token, obtained via Botfather
 *   'currency'                      => '',  //  string          - Required. Three-letter ISO 4217 currency code, see more on currencies
 *   'prices'                        => '',  //  LabeledPrice[]  - Required. Price breakdown, a JSON-serialized list of components (e.g. product price, tax, discount, delivery cost, delivery tax, bonus, etc.)
 *   'max_tip_amount'                => '',  //  int             - (Optional). The maximum accepted amount for tips in the smallest units of the currency (integer, not float/double). For example, for a maximum tip of US$ 1.45 pass max_tip_amount = 145. See the exp parameter in currencies.json, it shows the number of digits past the decimal point for each currency (2 for the majority of currencies). Defaults to 0
 *   'suggested_tip_amounts'         => '',  //  int[]           - (Optional). A JSON-serialized array of suggested amounts of tip in the smallest units of the currency (integer, not float/double). At most 4 suggested tip amounts can be specified. The suggested tip amounts must be positive, passed in a strictly increased order and must not exceed max_tip_amount.
 *   'provider_data'                 => '',  //  string          - (Optional). A JSON-serialized object for data about the invoice, which will be shared with the payment provider. A detailed description of the required fields should be provided by the payment provider.
 *   'photo_url'                     => '',  //  string          - (Optional). URL of the product photo for the invoice. Can be a photo of the goods or a marketing image for a service. People like it better when they see what they are paying for.
 *   'photo_size'                    => '',  //  int             - (Optional). Photo size
 *   'photo_width'                   => '',  //  int             - (Optional). Photo width
 *   'photo_height'                  => '',  //  int             - (Optional). Photo height
 *   'need_name'                     => '',  //  bool            - (Optional). Pass True, if you require the user's full name to complete the order
 *   'need_phone_number'             => '',  //  bool            - (Optional). Pass True, if you require the user's phone number to complete the order
 *   'need_email'                    => '',  //  bool            - (Optional). Pass True, if you require the user's email address to complete the order
 *   'need_shipping_address'         => '',  //  bool            - (Optional). Pass True, if you require the user's shipping address to complete the order
 *   'send_phone_number_to_provider' => '',  //  bool            - (Optional). Pass True, if user's phone number should be sent to provider
 *   'send_email_to_provider'        => '',  //  bool            - (Optional). Pass True, if user's email address should be sent to provider
 *   'is_flexible'                   => '',  //  bool            - (Optional). Pass True, if the final price depends on the shipping method
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inputinvoicemessagecontent
 */
class InputInvoiceMessageContent extends AbstractCreateObject
{
}
