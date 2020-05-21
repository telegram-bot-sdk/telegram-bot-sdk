<?php

namespace Telegram\Bot\FileUpload;

use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\PumpStream;
use GuzzleHttp\Psr7\Stream;
use Iterator;
use JsonSerializable;
use Psr\Http\Message\StreamInterface;

use function GuzzleHttp\Psr7\stream_for;

class InputFile implements JsonSerializable
{
    protected $contents;
    protected ?string $filename = null;
    protected string $multiPartName;

    /**
     * Creates a new InputFile object.
     *
     * @param             $contents
     * @param string|null $filename
     */
    public function __construct($contents, string $filename = null)
    {
        $this->contents = $contents;
        $this->filename = $filename;
        $this->multiPartName = $this->generateRandomName();
    }


    public static function file($file, $filename = null)
    {
        return new static(new LazyOpenStream($file, 'r+'), $filename);
    }

    //A filename for this method is COMPULSORY. Will fail if left out
    public static function contents($contents, $filename)
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
    public function getMultiPartName(): ?string
    {
        return $this->multiPartName;
    }

    /**
     * @return string
     */
    public function getAttachString(): string
    {
        return "attach://" . $this->getMultiPartName();
    }

    public function jsonSerialize()
    {
        return $this->getAttachString();
    }

    protected function generateRandomName()
    {
        return substr(md5(uniqid(rand(), true)), 0, 10);
    }
}
