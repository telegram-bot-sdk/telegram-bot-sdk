<?php

namespace Telegram\Bot\Http;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\CouldNotUploadInputFile;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Helpers\Validator;
use Telegram\Bot\Traits\HasAccessToken;

/**
 * Class TelegramClient.
 */
class TelegramClient
{
    use HasAccessToken;

    /** @var string Telegram Bot API URL. */
    protected string $baseApiUrl = 'https://api.telegram.org/bot';

    /** @var HttpClientInterface|null HTTP Client. */
    protected ?HttpClientInterface $httpClientHandler = null;

    /** @var bool Indicates if the request to Telegram will be asynchronous (non-blocking). */
    protected bool $isAsyncRequest = false;

    /** @var int Timeout of the request in seconds. */
    protected int $timeout = 60;

    /** @var int Connection timeout of the request in seconds. */
    protected int $connectTimeout = 10;

    /** @var TelegramResponse|null Stores the last request made to Telegram Bot API. */
    protected ?TelegramResponse $lastResponse;

    /**
     * Instantiates a new TelegramClient object.
     *
     * @param HttpClientInterface|null $httpClientHandler
     */
    public function __construct(HttpClientInterface $httpClientHandler = null)
    {
        $this->httpClientHandler = $httpClientHandler ?? new GuzzleHttpClient();
    }

    /**
     * Returns the HTTP client handler.
     *
     * @return HttpClientInterface
     */
    public function getHttpClientHandler(): HttpClientInterface
    {
        return $this->httpClientHandler ??= new GuzzleHttpClient();
    }

    /**
     * Sets the HTTP client handler.
     *
     * @param HttpClientInterface $httpClientHandler
     *
     * @return $this
     */
    public function setHttpClientHandler(HttpClientInterface $httpClientHandler): self
    {
        $this->httpClientHandler = $httpClientHandler;

        return $this;
    }

    /**
     * Get the Base API URL.
     *
     * @return string
     */
    public function getBaseApiUrl(): string
    {
        return $this->baseApiUrl;
    }

    /**
     * Set the Base API URL.
     *
     * @param string $baseApiUrl
     *
     * @return $this
     */
    public function setBaseApiUrl(string $baseApiUrl): self
    {
        $this->baseApiUrl = $baseApiUrl;

        return $this;
    }

    /**
     * Check if this is an asynchronous request (non-blocking).
     *
     * @return bool
     */
    public function isAsyncRequest(): bool
    {
        return $this->isAsyncRequest;
    }

    /**
     * Make this request asynchronous (non-blocking).
     *
     * @param bool $isAsyncRequest
     *
     * @return $this
     */
    public function setAsyncRequest(bool $isAsyncRequest): self
    {
        $this->isAsyncRequest = $isAsyncRequest;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     *
     * @return $this
     */
    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @return int
     */
    public function getConnectTimeout(): int
    {
        return $this->connectTimeout;
    }

    /**
     * @param int $connectTimeout
     *
     * @return $this
     */
    public function setConnectTimeout(int $connectTimeout): self
    {
        $this->connectTimeout = $connectTimeout;

        return $this;
    }

    /**
     * Returns the last response returned from API request.
     *
     * @return TelegramResponse|null
     */
    public function getLastResponse(): ?TelegramResponse
    {
        return $this->lastResponse;
    }

    /**
     * Sends a GET request to Telegram Bot API and returns the result.
     *
     * @param string $endpoint
     * @param array  $params
     * @param array  $jsonEncoded
     *
     * @throws TelegramSDKException
     * @return TelegramResponse
     */
    public function get(string $endpoint, array $params = [], array $jsonEncoded = []): TelegramResponse
    {
        $params = $this->jsonEncodeSpecified($params, $jsonEncoded);

        return $this->sendRequest('GET', $endpoint, $params);
    }

    /**
     * Sends a POST request to Telegram Bot API and returns the result.
     *
     * @param string $endpoint
     * @param array  $params
     * @param bool   $fileUpload Set true if a file is being uploaded.
     * @param array  $jsonEncode
     *
     * @throws TelegramSDKException
     * @return TelegramResponse
     */
    public function post(
        string $endpoint,
        array $params = [],
        bool $fileUpload = false,
        $jsonEncode = []
    ): TelegramResponse {
        $params = $this->normalizeParams($params, $fileUpload, $jsonEncode);

        return $this->sendRequest('POST', $endpoint, $params);
    }

    /**
     * Sends a multipart/form-data request to Telegram Bot API and returns the result.
     * Used primarily for file uploads.
     *
     * @param string $endpoint
     * @param array  $params
     * @param string $inputFileField
     * @param array  $jsonEncode
     *
     * @throws CouldNotUploadInputFile
     * @throws TelegramSDKException
     * @return TelegramResponse
     */
    public function uploadFile(string $endpoint, array $params, string $inputFileField, array $jsonEncode = []): TelegramResponse
    {
        //Check if the field in the $params array (that is being used to send the relative file), is a file id.
        if (!isset($params[$inputFileField])) {
            throw CouldNotUploadInputFile::missingParam($inputFileField);
        }

        if (Validator::hasFileId($inputFileField, $params)) {
            return $this->post($endpoint, $params, false, $jsonEncode);
        }

        // Sending an actual file requires it to be sent using multipart/form-data
        return $this->post($endpoint, $this->prepareMultipartParams($params, $inputFileField), true, $jsonEncode);
    }

    /**
     * Json Encodes specific parameters in the $params array when needed.
     *
     * @param array $params
     * @param array $jsonEncodeList
     *
     * @return array
     */
    protected function jsonEncodeSpecified(array $params, array $jsonEncodeList): array
    {
        collect($jsonEncodeList)
            ->push('reply_markup') //Add this as default as it is always required if set.
            ->unique()
            ->each(function ($keyToEncode) use (&$params) {
                if (isset($params[$keyToEncode]) && !is_string($params[$keyToEncode])) {
                    $params[$keyToEncode] = json_encode($params[$keyToEncode]);
                }
            });

        return $params;
    }

    /**
     * Prepare Multipart Params for File Upload.
     *
     * @param array  $params
     * @param string $inputFileField
     *
     * @throws CouldNotUploadInputFile
     *
     * @return array
     */
    protected function prepareMultipartParams(array $params, string $inputFileField): array
    {
        $this->validateInputFileField($params, $inputFileField);

        // Iterate through all param options and convert to multipart/form-data.
        return collect($params)
            ->reject(fn ($value) => null === $value)
            ->map(fn ($contents, $name) => $this->generateMultipartData($contents, $name))
            ->values()
            ->all();
    }

    /**
     * Generates the multipart data required when sending files to telegram.
     *
     * @param mixed  $contents
     * @param string $name
     *
     * @return array
     */
    protected function generateMultipartData($contents, string $name): array
    {
        if (!Validator::isInputFile($contents)) {
            return compact('name', 'contents');
        }

        return [
            'name'     => $name,
            'contents' => $contents->getContents(),
            'filename' => $contents->getFilename(),
        ];
    }

    /**
     * @param array  $params
     * @param string $inputFileField
     *
     * @throws CouldNotUploadInputFile
     */
    protected function validateInputFileField(array $params, string $inputFileField): void
    {
        if (!isset($params[$inputFileField])) {
            throw CouldNotUploadInputFile::missingParam($inputFileField);
        }

        // All file-paths, urls, or file resources should be provided by using the InputFile object
        if (
            (!$params[$inputFileField] instanceof InputFile) ||
            (is_string($params[$inputFileField]) && !Validator::isJson($params[$inputFileField]))
        ) {
            throw CouldNotUploadInputFile::inputFileParameterShouldBeInputFileEntity($inputFileField);
        }
    }

    /**
     * @param array $params
     * @param bool  $fileUpload
     * @param array $jsonEncode
     *
     * @return array
     */
    protected function normalizeParams(array $params, bool $fileUpload = false, array $jsonEncode = []): array
    {
        $encodedParams = $this->jsonEncodeSpecified($params, $jsonEncode);

        return $fileUpload ? ['multipart' => $encodedParams] : ['form_params' => $encodedParams];
    }

    /**
     * Instantiates a new TelegramRequest entity.
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $params
     *
     * @throws TelegramSDKException
     * @return TelegramRequest
     */
    protected function resolveTelegramRequest(string $method, string $endpoint, array $params = []): TelegramRequest
    {
        return (new TelegramRequest(
            $this->getAccessToken(),
            $method,
            $endpoint,
            $params,
            $this->isAsyncRequest()
        ))
            ->setTimeout($this->getTimeout())
            ->setConnectTimeout($this->getConnectTimeout());
    }

    /**
     * Sends a request to Telegram Bot API and returns the result.
     *
     * @param string $method
     * @param string $endpoint
     * @param array  $params
     *
     * @throws TelegramSDKException
     *
     * @return TelegramResponse
     */
    protected function sendRequest(string $method, string $endpoint, array $params = []): TelegramResponse
    {
        $request = $this->resolveTelegramRequest($method, $endpoint, $params);

        $rawResponse = $this->getHttpClientHandler()
            ->setTimeout($request->getTimeout())
            ->setConnectTimeout($request->getConnectTimeout())
            ->send(
                $this->makeApiUrl($request),
                $request->getMethod(),
                $request->getHeaders(),
                $this->getOption($request, $method),
                $request->isAsyncRequest(),
            );

        $returnResponse = $this->getResponse($request, $rawResponse);

        if ($returnResponse->isError()) {
            throw $returnResponse->getThrownException();
        }

        return $this->lastResponse = $returnResponse;
    }

    /**
     * Make API URL.
     *
     * @param TelegramRequest $request
     *
     * @throws TelegramSDKException
     * @return string
     */
    protected function makeApiUrl(TelegramRequest $request): string
    {
        return $this->getBaseApiUrl() . $request->getAccessToken() . '/' . $request->getEndpoint();
    }

    /**
     * Creates response object.
     *
     * @param TelegramRequest                    $request
     * @param ResponseInterface|PromiseInterface $response
     *
     * @return TelegramResponse
     */
    protected function getResponse(TelegramRequest $request, $response): TelegramResponse
    {
        return new TelegramResponse($request, $response);
    }

    /**
     * @param TelegramRequest $request
     * @param string          $method
     *
     * @return array
     */
    protected function getOption(TelegramRequest $request, string $method): array
    {
        if ($method === 'POST') {
            return $request->getPostParams();
        }

        return ['query' => $request->getParams()];
    }
}
