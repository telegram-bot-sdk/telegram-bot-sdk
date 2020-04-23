<?php

namespace Telegram\Bot\Objects;

/**
 * Class WebhookInfo.
 *
 * Contains information about the current status of a webhook.
 *
 * @link https://core.telegram.org/bots/api#webhooki    nfo
 *
 * @property string $url                     Webhook URL, may be empty if webhook is not set up
 * @property bool   $has_custom_certificate  True, if a custom certificate was provided for webhook certificate checks
 * @property int    $pending_update_count    Number of updates awaiting delivery
 * @property int    $last_error_date         (Optional). Unix time for the most recent error that happened when trying to deliver an update via webhook
 * @property string $last_error_message      (Optional). Error message in human-readable format for the most recent error that happened when trying to deliver an update via webhook
 * @property int    $max_connections         (Optional). Maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery
 * @property array  $allowed_updates         (Optional). A list of update types the bot is subscribed to. Defaults to all update types
 */
class WebhookInfo extends BaseObject
{
}
