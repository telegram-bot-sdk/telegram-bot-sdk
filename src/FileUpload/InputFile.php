<?php

namespace Telegram\Bot\FileUpload;

use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\Utils;
use JsonSerializable;
use Telegram\Bot\Contracts\Multipartable;

final class InputFile implements JsonSerializable, Multipartable
{
    private string $multipartName;

    public function __construct(protected mixed $contents, protected ?string $filename = null)
    {
        $this->multipartName = $this->generateRandomName();
    }

    public static function file(string $file, ?string $filename = null): self
    {
        return new self(new LazyOpenStream($file, 'rb'), $filename);
    }

    public static function contents(mixed $contents, string $filename): self
    {
        return new self(Utils::streamFor($contents), $filename);
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function getContents(): mixed
    {
        return $this->contents;
    }

    public function getMultipartName(): string
    {
        return $this->multipartName;
    }

    public function setMultipartName(string $multipartName): self
    {
        $this->multipartName = $multipartName;

        return $this;
    }

    public function getAttachString(): string
    {
        return 'attach://'.$this->multipartName;
    }

    public function jsonSerialize(): mixed
    {
        return $this->getAttachString();
    }

    /**
     * @return array{name: string, contents: mixed, filename: string|null}
     */
    public function __toMultipart(): array
    {
        return [
            'name' => $this->multipartName,
            'contents' => $this->contents,
            'filename' => $this->filename,
        ];
    }

    private function generateRandomName(): string
    {
        return bin2hex(random_bytes(5));
    }
}
