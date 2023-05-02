<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\ResponseObject;
use Telegram\Bot\Traits\Http;

/**
 * @mixin Http
 */
trait GettingUpdates
{
    /**
     * Use this method to receive incoming updates using long polling.
     *
     * @link https://core.telegram.org/bots/api#getupdates
     *
     * @param array{
     * 	offset: int,
     * 	limit: int,
     * 	timeout: int,
     * 	allowed_updates: string[],
     * } $params
     * @return ResponseObject<array{
     *     update_id: int,
     *     message: array,
     *     edited_message: array,
     *     channel_post: array,
     *     edited_channel_post: array,
     *     inline_query: array,
     *     chosen_inline_result: array,
     *     callback_query: array,
     *     shipping_query: array,
     *     pre_checkout_query: array,
     *     poll: array,
     *     poll_answer: array,
     *     my_chat_member: array,
     *     chat_member: array,
     *     chat_join_request: array
     * }>
     */
    public function getUpdates(array $params = []): ResponseObject
    {
        return $this->get('getUpdates', $params)->getResult();
    }

    /**
     * Specify a URL and receive incoming updates via an outgoing webhook
     *
     * If you'd like to make sure that the webhook was set by you, you can specify secret data in the parameter secret_token. If specified, the request will contain a header “X-Telegram-Bot-Api-Secret-Token” with the secret token as content.
     *
     * @link https://core.telegram.org/bots/api#setwebhook
     *
     * @param array{
     * 	url: string,
     * 	certificate: InputFile,
     * 	ip_address: string,
     * 	max_connections: int,
     * 	allowed_updates: string[],
     * 	drop_pending_updates: bool,
     *  secret_token: string,
     * } $params
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
     * Returns True on success.
     *
     * @link https://core.telegram.org/bots/api#deletewebhook
     *
     * @param array{
     * 	drop_pending_updates: bool,
     * } $params
     */
    public function deleteWebhook(array $params = []): bool
    {
        return $this->get('deleteWebhook', $params)->getResult();
    }

    /**
     * Get current webhook status.
     *
     * Requires no parameters. On success, returns a WebhookInfo object. If the bot is using getUpdates, will return an object with the url field empty.
     *
     * @link https://core.telegram.org/bots/api#getwebhookinfo
     *
     * @return ResponseObject{
     *   url: string,
     *   has_custom_certificate: bool,
     *   pending_update_count: int,
     *   ip_address: string,
     *   last_error_date: int,
     *   last_error_message: string,
     *   last_synchronization_error_date: int,
     *   max_connections: int,
     *   allowed_updates: string[]
     * }
     */
    public function getWebhookInfo(): ResponseObject
    {
        return $this->get('getWebhookInfo')->getResult();
    }

    /**
     * Returns a webhook update sent by Telegram.
     * Works only if you set a webhook.
     *
     * @see setWebhook
     */
    public function getWebhookUpdate(): ResponseObject
    {
        $body = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);

        return new ResponseObject($body);
    }

    /**
     * Confirm update as received.
     */
    public function confirmUpdate(int $highestId): ResponseObject
    {
        return $this->getUpdates([
            'offset' => $highestId + 1,
            'limit' => 1,
        ]);
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
}
