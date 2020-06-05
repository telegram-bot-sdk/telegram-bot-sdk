<?php

namespace Telegram\Bot\Tests\Unit\FileUpload;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Telegram\Bot\FileUpload\InputFile;

use function GuzzleHttp\Psr7\stream_for;

class InputFileTest extends TestCase
{

    protected InputFile $fileOnDisk;
    protected InputFile $fileFromContents;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fileOnDisk = InputFile::file('php://tmp');
        $this->fileFromContents = InputFile::contents('Some String', 'filename.txt');
    }

    /** @test */
    public function it_creates_a_multipart_name_automatically()
    {
        $this->assertNotNull($this->fileOnDisk->getMultipartName());
    }

    /** @test */
    public function it_requires_a_filename_if_the_contents_of_a_file_are_only_used_to_create_the_object()
    {
        $this->assertNotNull($this->fileFromContents->getFilename());
        $this->assertNull($this->fileOnDisk->getFilename());
    }

    /** @test */
    public function the_attach_string_must_contain_the_multipart_name()
    {
        $this->assertStringContainsString($this->fileOnDisk->getMultipartName(), $this->fileOnDisk->getAttachString());
    }

    /** @test */
    public function the_contents_must_always_return_a_stream_no_matter_what_input_was_given()
    {
        $inputFile01 = InputFile::contents(stream_for('string'), 'filename01.txt');

        $this->assertInstanceOf(StreamInterface::class, $this->fileOnDisk->getContents());
        $this->assertInstanceOf(StreamInterface::class, $this->fileFromContents->getContents());
        $this->assertInstanceOf(StreamInterface::class, $inputFile01->getContents());
    }

    /** @test */
    public function it_provides_the_correct_format_for_multipart_data()
    {
        $this->assertSame($this->fileFromContents->getMultipartName(), $this->fileFromContents->toMultipart()['name']);
        $this->assertSame($this->fileFromContents->getContents(), $this->fileFromContents->toMultipart()['contents']);
        $this->assertSame($this->fileFromContents->getFilename(), $this->fileFromContents->toMultipart()['filename']);
    }
}
