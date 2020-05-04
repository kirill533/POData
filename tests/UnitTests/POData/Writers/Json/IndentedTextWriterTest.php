<?php

declare(strict_types=1);

namespace UnitTests\POData\Writers\Json;

use POData\Writers\Json\IndentedTextWriter;
use UnitTests\POData\TestCase;

class IndentedTextWriterTest extends TestCase
{

    function tearDown()
    {
        IndentedTextWriter::$PHP_EOL = "\n";
        parent::tearDown();
    }

    function getEOL()
    {
        return [["\n"],["\r\n"]];
    }

    /**
     * @dataProvider getEOL()
     * @param $eol
     */
    public function testWriteLine($eol)
    {
        IndentedTextWriter::$PHP_EOL = $eol;
        $writer = new IndentedTextWriter('');

        $result = $writer->writeLine();
        $this->assertSame($writer, $result);
        $this->assertEquals(IndentedTextWriter::$PHP_EOL, $writer->getResult());
    }

    public function testWrite()
    {
        $writer = new IndentedTextWriter('');

        $result = $writer->writeValue(' doggy ');

        $this->assertSame($writer, $result);
        $this->assertEquals(' doggy ', $writer->getResult());
    }

    public function testWriteTrimmed()
    {
        $writer = new IndentedTextWriter('');

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
        IndentedTextWriter::$PHP_EOL = $eol;
        $writer = new IndentedTextWriter('');

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
        $expected = 'indented1x' . IndentedTextWriter::$PHP_EOL . '        indented2x' . IndentedTextWriter::$PHP_EOL
            . '    indented1xtrimmed' . IndentedTextWriter::$PHP_EOL . 'indented0x';

        $this->assertEquals($expected, $writer->getResult());
    }
}
