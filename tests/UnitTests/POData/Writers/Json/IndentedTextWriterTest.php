<?php

declare(strict_types=1);

namespace UnitTests\POData\Writers\Json;

use POData\Writers\Json\IndentedTextWriter;
use UnitTests\POData\TestCase;

class IndentedTextWriterTest extends TestCase
{

    function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @dataProvider getEOL()
     * @param $eol
     */
    function testWriteLine($eol)
    {
        $writer = new IndentedTextWriter('', $eol, true);

        $result = $writer->writeLine();
        $this->assertSame($writer, $result);
        $this->assertEquals($eol, $writer->getResult());
    }

    public function testWrite()
    {
        $writer = new IndentedTextWriter('', PHP_EOL, true);

        $result = $writer->writeValue(' doggy ');

        $this->assertSame($writer, $result);
        $this->assertEquals(' doggy ', $writer->getResult());
    }

    public function testWriteTrimmed()
    {
        $writer = new IndentedTextWriter('', PHP_EOL, true);

        $result = $writer->writeTrimmed(' doggy ');

        $this->assertSame($writer, $result);
        $this->assertEquals('doggy', $writer->getResult());
    }

    /**
     * @dataProvider getEOL()
     * @param $eol
     */
    public function testWriteIndents($eol)
    {
        $writer = new IndentedTextWriter('', $eol, true);

        $result = $writer->increaseIndent();
        $this->assertSame($writer, $result);

        $writer->writeValue('indented1x');
        $writer->writeLine();

        $writer->increaseIndent();
        $writer->writeValue('indented2x');
        $writer->writeLine();

        $result = $writer->decreaseIndent();
        $this->assertSame($writer, $result);
        $writer->writeValue('indented1x');
        $writer->writeTrimmed('  trimmed  ');
        $writer->writeLine();

        $writer->decreaseIndent();
        $writer->decreaseIndent();
        $writer->decreaseIndent();
        $writer->decreaseIndent();
        $writer->decreaseIndent();
        $writer->decreaseIndent();
        $writer->decreaseIndent();

        $writer->writeValue('indented0x');
        $expected = 'indented1x' . $eol . '        indented2x' . $eol
            . '    indented1xtrimmed' . $eol . 'indented0x';

        $this->assertEquals($expected, $writer->getResult());
    }
}
