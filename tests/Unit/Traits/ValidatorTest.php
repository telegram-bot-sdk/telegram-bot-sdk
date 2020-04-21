<?php

namespace Telegram\Bot\Tests\Unit\Traits;

use PHPUnit\Framework\TestCase;
use Telegram\Bot\Helpers\Validator;

class ValidatorTest extends TestCase
{
    /** @test */
    public function it_checks_it_can_detect_a_file_id()
    {
        $result01 = Validator::isFileId('https://short.url');
        $result02 = Validator::isFileId('/path/to/file.pdf');
        $result03 = Validator::isFileId([]);
        $result04 = Validator::isFileId('asuperlongfilenamethatisover20characters.pdf');

        $result10 = Validator::isFileId('AwADBAADYwADO1wlBuF1ogMa7HnMAg');

        $this->assertFalse($result01);
        $this->assertFalse($result02);
        $this->assertFalse($result03);
        $this->assertFalse($result04);

        $this->assertTrue($result10);
    }
}
