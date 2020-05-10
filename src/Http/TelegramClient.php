<?php

namespace Telegram\Bot\Http;

use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\ResponseInterface;
use Telegram\Bot\Exceptions\CouldNotUploadInputFile;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Helpers\Validator;
use Telegram\Bot\Objects\InputMedia\InputMedia;
use Telegram\Bot\Traits\HasAccessToken;

/**
 * Class TelegramClient.
 */
class TelegramClient
{
    use HasAccessToken;

    /** @var string Telegram Bot API URL. */
    protected string $baseBotUrl = 'https://api.telegram.org/bot';

    /** @var HttpClientInterface|null HTTP Client. */
    protected ?HttpClientInterface $httpClientHandler = null;

    /** @var bool Indicates if the request to Telegram will be asynchronous (non-blocking). */
    protected bool $isAsyncRequest = false;

    /** @var int Timeout of the request in seconds. */
    protected int $timeOut = 60;

    /** @var int Connection timeout of the request in seconds. */
    protected int $connectTimeOut = 10;

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
     * Get the Base Bot API URL.
     *
     * @return string
     */
    public function getBaseBotUrl(): string
    {
        return $this->baseBotUrl;
    }

    /**
     * Set the Base Bot API URL.
     *
     * @param string $baseBotUrl
     *
     * @return $this
     */
    public function setBaseBotApiUrl(string $baseBotUrl): self
    {
        $this->baseBotUrl = $baseBotUrl;

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
    public function getTimeOut(): int
    {
        return $this->timeOut;
    }

    /**
     * @param int $timeOut
     *
     * @return $this
     */
    public function setTimeOut(int $timeOut): self
    {
        $this->timeOut = $timeOut;

        return $this;
    }

    /**
     * @return int
     */
    public function getConnectTimeOut(): int
    {
        return $this->connectTimeOut;
    }

    /**
     * @param int $connectTimeOut
     *
     * @return $this
     */
    public function setConnectTimeOut(int $connectTimeOut): self
    {
        $this->connectTimeOut = $connectTimeOut;

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
    public function uploadFile(
        string $endpoint,
        array $params,
        string $inputFileField,
        array $jsonEncode = []
    ): TelegramResponse {
        //Check if the field in the $params array (that is being used to send the relative file) is actually set.
        if (!isset($params[$inputFileField])) {
            throw CouldNotUploadInputFile::missingParam($inputFileField);
        }

/**
When we get here from a normal method like sendPhoto, we take parameters like this:

        [
            'chat_id' => 12443287,
            'photo'   => InputFile::create('file1.png'),
            'caption' => 'My caption',
        ];

And turn it into

        [
            'multipart' => [
                [
                    'name'     => 'chat_id',
                    'contents' => '12443287',
                ],
                [
                    'name'     => 'photo',
                    'contents' => 'Allthefilecontentshere',
                    'filename' => 'file1.png'
                ],
                [
                    'name'     => 'caption',
                    'contents' => 'My caption',
                ],
        ];
 Each key of the params array becomes the value for the name key in the multipart array.


 However when we use sendMediaGroup, this is NOT how it works. Instead we must provide a params array like this:


        [
            'chat_id' => 12443287,
            'media'   => [
                [
                    'type' => 'photo',
                    'media' => 'attach://ahsgdnagsah',
                    'caption' => 'My Caption 1'
                ],
                [
                    'type' => 'photo',
                    'media' => 'attach://jhhxvbvjhsj',
                    'caption' => 'My Caption 2'
                ],
                [
                    'type' => 'photo',
                    'media' => 'attach://twhsjahjsjj',
                    'caption' => 'My Caption 3'
                ]
            ],
        ];

 Notice how there are TWO levels of media keys.
 The second level MEDIA key does NOT contain the file contents. It only contains a reference to what key must be included
 in the final multipart array when it is send via guzzle.

 In this case we must have 3 arrays in the final multipart array that have a name of   ahsgdnagsah, jhhxvbvjhsj, and twhsjahjsjj.
  I can find no reference in docs as to what these names should be or how they should be created so I have just made a random
 string when generating them. Seems to work

The FIRST level media key containing all this description must be json encoded. So our final multipart array will look like this:

        [
            'multipart' => [
                [
                    'name'     => 'chat_id',
                    'contents' => '12443287',
                ],
                [
                    'name'     => 'media',
                    'contents' => '[{"media":"attach:\/\/ahsgdnagsah","caption":"My caption 1","type":"photo"},{"media":"attach:\/\/jhhxvbvjhsj","caption":"My caption 2","type":"photo"},{"media":"attach:\/\/twhsjahjsjj","caption":"My caption 3","type":"photo"}]',
                ],
                [
                    'name'     => 'ahsgdnagsah',
                    'contents' => 'Actual File Contents...use a stream here',
                    'filename' => 'file1.png'
                ],
                [
                    'name'     => '91dbb935df',
                    'contents' => 'Actual File Contents...use a stream here',
                    'filename' => 'file2.png'
                ],
                [
                    'name'     => '99ca7d9191',
                    'contents' => 'Actual File Contents...use a stream here',
                    'filename' => 'file3.png'
                ],
            ],
        ]


So this is where I'm struggling with the implementation.

Using sendMediaGroup as example, we receive the params and the media key is an array of say InputMediaPhoto
When this gets json_encoded, I have got it to return the correct string to provide the description as mentioned above.
Then, I can go through each param and convert it into a a multipart array equivilent.

BUT when it comes to the media key, THAT is an array. And it is an array describing how to add MORE keys to the multipart array
ie. I'm not mapping the media key directly...I'm trying to read what the media key HAS and use that to generate another item to
add to the multipart array. That part I am finding very tricky.

 Trying to break the code down below to be easy to follow....but it's not!
 **/

        //Generate the multipart array normally for the params like usual.
        //This covers most methods with a single file upload in ONE parameter.
        $encodedMultipartParams = collect(
            $this->convertParamsToMultipart($this->jsonEncodeSpecified($params, $jsonEncode), $inputFileField)
        );

        //If there are an array of files that need to be uploaded we need to generate the multipart data for each of
        //those now by using the name we gave/generated in the original media key.
        $extraMultiParts = $this->generateMultipartDataForArrayOfFiles($params[$inputFileField]);

        $multipart = [
            'multipart' => $encodedMultipartParams->merge($extraMultiParts)->all(),
        ];

        // Sending an actual file requires it to be sent using multipart/form-data
        return $this->sendRequest('POST', $endpoint, $multipart);
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
    protected function convertParamsToMultipart(array $params, string $inputFileField): array
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

    protected function generateMultipartDataForArrayOfFiles($multipleFiles)
    {
        if (!is_array($multipleFiles)) {
            return [];
        }

        return collect($multipleFiles)
            //Get the InputFile from every InputMedia Object in this array.
            ->map(fn (InputMedia $item) => $item->getInputFile())

            // If the user only supplied a URL or file_id as a string and not a InputFile, then we can
            // ignore it, we only need to do this for uploaded files.
            ->filter(fn ($item) => $item instanceof InputFile)

            //Generate a new multipart array for each New Input File.
            ->map(function (InputFile $inputFile) {
                return $this->generateMultipartData($inputFile, $inputFile->getMultiPartName());
            })
            ->values();
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

//        // All file-paths, urls, or file resources should be provided by using the InputFile object
//        if (
//            (!$params[$inputFileField] instanceof InputFile) ||
//            (is_string($params[$inputFileField]) && !Validator::isJson($params[$inputFileField]))
//        ) {
//            throw CouldNotUploadInputFile::inputFileParameterShouldBeInputFileEntity($inputFileField);
//        }
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
            ->setTimeOut($this->getTimeOut())
            ->setConnectTimeOut($this->getConnectTimeOut());
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
            ->setTimeOut($request->getTimeOut())
            ->setConnectTimeOut($request->getConnectTimeOut())
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
        return $this->getBaseBotUrl() . $request->getAccessToken() . '/' . $request->getEndpoint();
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
