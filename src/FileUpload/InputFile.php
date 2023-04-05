<?php

namespace Telegram\Bot\FileUpload;

use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\PumpStream;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Utils;
use Iterator;
use JsonSerializable;
use Psr\Http\Message\StreamInterface;
use Telegram\Bot\Contracts\Multipartable;

class InputFile implements Multipartable, JsonSerializable
{
    protected string $multipartName;

    /**
     * Creates a new InputFile object.
     */
    public function __construct(protected mixed $contents, protected ?string $filename = null)
    {
        $this->multipartName = $this->generateRandomName();
    }

    /**
     * @return static
     */
    public static function file(string $file, string $filename = null): self
    {
        return new static(new LazyOpenStream($file, 'rb'), $filename);
    }

    /**
     * @return static
     */
    public static function contents(mixed $contents, string $filename): self
    {
        return new static(Utils::streamFor($contents), $filename);
    }

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

    public function getMultipartName(): string
    {
        return $this->multipartName;
    }

    /**
     * @return $this
     */
    public function setMultipartName(string $multipartName): self
    {
        $this->multipartName = $multipartName;

        return $this;
    }

    public function getAttachString(): string
    {
        return 'attach://'.$this->getMultipartName();
    }

    public function jsonSerialize(): mixed
    {
        return $this->getAttachString();
    }

    /**
     * @return array{name: string, contents: bool|callable|float|int|\Iterator|\Psr\Http\Message\StreamInterface|resource|string|null, filename: string|null}
     */
    public function toMultipart(): array
    {
        return [
            'name' => $this->getMultipartName(),
            'contents' => $this->getContents(),
            'filename' => $this->getFilename(),
        ];
    }

    protected function generateRandomName(): string
    {
        return substr(md5(uniqid('', true)), 0, 10);
    }
}
