<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\Update as UpdateObject;
use Telegram\Bot\Objects\WebhookInfo;
use Telegram\Bot\Traits\Http;

/**
 * Class Update.
 *
 * @mixin Http
 */
trait Update
{
    /**
     * Use this method to receive incoming updates using long polling.
     *
     * <code>
     * $params = [
     *       'offset'           => '',  // int   - (Optional). Identifier of the first update to be returned. Must be greater by one than the highest among the identifiers of previously received updates. By default, updates starting with the earliest unconfirmed update are returned. An update is considered confirmed as soon as getUpdates is called with an offset higher than its update_id. The negative offset can be specified to retrieve update starting from -offset update from the end of the updates queue. All previous updates will forgotten.
     *       'limit'            => '',  // int   - (Optional). Limits the number of updates to be retrieved. Values between 1—100 are accepted. Defaults to 100.
     *       'timeout'          => '',  // int   - (Optional). Timeout in seconds for long polling. Defaults to 0, i.e. usual short polling. Should be positive, short polling should be used for testing purposes only.
     *       'allowed_updates'  => '',  // array - (Optional). List the types of updates you want your bot to receive. For example, specify [“message”, “edited_channel_post”, “callback_query”] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all updates regardless of type (default). If not specified, the previous setting will be used.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#getupdates
     *
     * @param array $params
     *
     * @throws TelegramSDKException
     *
     * @return UpdateObject[]
     */
    public function getUpdates(array $params = []): array
    {
        $response = $this->get('getUpdates', $params);

        return collect($response->getResult())
            ->mapInto(UpdateObject::class)
            ->all();
    }

    /**
     * Confirm update as received.
     *
     * @param int $highestId
     *
     * @throws TelegramSDKException
     *
     * @return array
     */
    public function confirmUpdate(int $highestId): array
    {
        return $this->getUpdates([
            'offset' => $highestId + 1,
            'limit'  => 1,
        ]);
    }

    /**
     * Set a Webhook to receive incoming updates via an outgoing webhook.
     *
     * <code>
     * $params = [
     *       'url'                  => '',                      // string    - Required. HTTPS url to send updates to. Use an empty string to remove webhook integration
     *       'certificate'          => InputFile::file($file),  // InputFile - (Optional). Upload your public key certificate so that the root certificate in use can be checked. See our self-signed guide for details.
     *       'ip_address'           => '',                      // string    - (Optional). The fixed IP address which will be used to send webhook requests instead of the IP address resolved through DNS
     *       'max_connections'      => '',                      // int       - (Optional). Maximum allowed number of simultaneous HTTPS connections to the webhook for update delivery, 1-100. Defaults to 40. Use lower values to limit the load on your bot‘s server, and higher values to increase your bot’s throughput.
     *       'allowed_updates'      => '',                      // array     - (Optional). List the types of updates you want your bot to receive. For example, specify [“message”, “edited_channel_post”, “callback_query”] to only receive updates of these types. See Update for a complete list of available update types. Specify an empty list to receive all updates regardless of type (default). If not specified, the previous setting will be used.
     *       'drop_pending_updates' => '',                      // bool      - (Optional). Pass True to drop all pending updates.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#setwebhook
     *
     * @param array $params
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function setWebhook(array $params): bool
    {
        if (isset($params['certificate'])) {
            $params['certificate'] = $this->formatCertificate($params['certificate']);

            if (isset($params['allowed_updates']) && is_array($params['allowed_updates'])) {
                $params['allowed_updates'] = json_encode($params['allowed_updates']);
            }

            return $this->uploadFile('setWebhook', $params)->getResult();
        }

        return $this->post('setWebhook', $params)->getResult();
    }

    /**
     * Remove webhook integration if you decide to switch back to getUpdates.
     *
     * <code>
     * $params = [
     *       'drop_pending_updates' => '',  // bool      - (Optional). Pass True to drop all pending updates.
     * ]
     * </code>
     *
     * @link https://core.telegram.org/bots/api#deletewebhook
     *
     * @throws TelegramSDKException
     * @return bool
     */
    public function deleteWebhook(): bool
    {
        return $this->get('deleteWebhook')->getResult();
    }

    /**
     * Get current webhook status.
     *
     * @link https://core.telegram.org/bots/api#getwebhookinfo
     *
     * @throws TelegramSDKException
     *
     * @return WebhookInfo
     */
    public function getWebhookInfo(): WebhookInfo
    {
        $response = $this->get('getWebhookInfo');

        return new WebhookInfo($response->getDecodedBody());
    }

    /**
     * Returns a webhook update sent by Telegram.
     * Works only if you set a webhook.
     *
     * @return UpdateObject
     * @see setWebhook
     */
    public function getWebhookUpdate(): UpdateObject
    {
        $body = json_decode(file_get_contents('php://input'), true);

        return new UpdateObject($body);
    }

    /**
     * Alias for deleteWebhook.
     *
     * @throws TelegramSDKException
     *
     * @return bool
     */
    public function removeWebhook(): bool
    {
        return $this->deleteWebhook();
    }

    /**
     * Format Certificate.
     *
     * @param $certificate
     *
     * @return InputFile
     */
    protected function formatCertificate($certificate): InputFile
    {
        if ($certificate instanceof InputFile) {
            return $certificate;
        }

        return InputFile::file($certificate, 'certificate.pem');
    }

    /**
     * Use this method to log out from the cloud Bot API server before launching the bot locally.
     *
     * @link https://core.telegram.org/bots/api#logout
     *
     * @throws TelegramSDKException
     * @return bool
     */
    public function logOut(): bool
    {
        return $this->get('logout')->getResult();
    }

    /**
     * Use this method to close the bot instance before moving it from one local server to another.
     *
     * @link https://core.telegram.org/bots/api#logout
     *
     * @throws TelegramSDKException
     * @return bool
     */
    public function close(): bool
    {
        return $this->get('close')->getResult();
    }
}
