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
     * @param array{
     * 	offset: int,
     * 	limit: int,
     * 	timeout: int,
     * 	allowed_updates: array,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#getupdates
     *
     * @return UpdateObject[]
     *
     * @throws TelegramSDKException
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
     *
     * @throws TelegramSDKException
     */
    public function confirmUpdate(int $highestId): array
    {
        return $this->getUpdates([
            'offset' => $highestId + 1,
            'limit' => 1,
        ]);
    }

    /**
     * Set a Webhook to receive incoming updates via an outgoing webhook.
     *
     * @param array{
     * 	url: string,
     * 	certificate: InputFile,
     * 	ip_address: string,
     * 	max_connections: int,
     * 	allowed_updates: array,
     * 	drop_pending_updates: bool,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#setwebhook
     *
     * @throws TelegramSDKException
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
     * @param array{
     * 	drop_pending_updates: bool,
     * } $params
     *
     * @link https://core.telegram.org/bots/api#deletewebhook
     *
     * @throws TelegramSDKException
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
     */
    public function removeWebhook(): bool
    {
        return $this->deleteWebhook();
    }

    /**
     * Format Certificate.
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
     */
    public function logOut(): bool
    {
        return $this->get('logout')->getResult();
    }

    /**
     * Use this method to close the bot instance before moving it from one local server to another.
     *
     * @link https://core.telegram.org/bots/api#logout
     */
    public function close(): bool
    {
        return $this->get('close')->getResult();
    }
}
