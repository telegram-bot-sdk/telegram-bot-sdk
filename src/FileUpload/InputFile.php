<?php

namespace Telegram\Bot\FileUpload;

use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\PumpStream;
use GuzzleHttp\Psr7\Stream;
use Iterator;
use JsonSerializable;
use Psr\Http\Message\StreamInterface;
use Telegram\Bot\Contracts\Multipartable;

use function GuzzleHttp\Psr7\stream_for;

class InputFile implements Multipartable, JsonSerializable
{
    protected $contents;
    protected ?string $filename = null;
    protected string $multipartName;

    /**
     * Creates a new InputFile object.
     *
     * @param mixed       $contents
     * @param string|null $filename
     */
    public function __construct($contents, string $filename = null)
    {
        $this->contents = $contents;
        $this->filename = $filename;
        $this->multipartName = $this->generateRandomName();
    }

    /**
     * @param string      $file
     * @param string|null $filename
     *
     * @return static
     */
    public static function file(string $file, string $filename = null): self
    {
        return new static(new LazyOpenStream($file, 'r'), $filename);
    }

    /**
     * @param mixed  $contents
     * @param string $filename
     *
     * @return static
     */
    public static function contents($contents, string $filename): self
    {
        return new static(stream_for($contents), $filename);
    }

    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @return bool|callable|float|PumpStream|Stream|int|Iterator|StreamInterface|resource|string|null
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @return string|null
     */
    public function getMultipartName(): ?string
    {
        return $this->multipartName;
    }

    /**
     * @param string $multipartName
     *
     * @return $this
     */
    public function setMultipartName(string $multipartName): self
    {
        $this->multipartName = $multipartName;

        return $this;
    }

    /**
     * @return string
     */
    public function getAttachString(): string
    {
        return 'attach://' . $this->getMultipartName();
    }

    public function jsonSerialize()
    {
        return $this->getAttachString();
    }

    /**
     * @return array
     */
    public function toMultipart(): array
    {
        return [
            'name'     => $this->getMultipartName(),
            'contents' => $this->getContents(),
            'filename' => $this->getFilename(),
        ];
    }

    protected function generateRandomName(): string
    {
        return substr(md5(uniqid(rand(), true)), 0, 10);
    }
}
