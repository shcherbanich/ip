<?php

namespace Darsyn\IP\Tests\Formatter;

use Darsyn\IP\Exception\Formatter\FormatException;
use Darsyn\IP\Formatter\ConsistentFormatter as Formatter;
use Darsyn\IP\Formatter\ProtocolFormatterInterface;
use Darsyn\IP\Tests\TestCase;

class ConsistentFormatterTest extends TestCase
{
    /** @var \Darsyn\IP\Formatter\ProtocolFormatterInterface $formatter */
    private $formatter;

    protected function setUp()
    {
        parent::setUp();
        $this->formatter = new Formatter;
    }

    /**
     * @test
     */
    public function testFormatterIsInstanceOfInterface()
    {
        $this->assertInstanceOf(ProtocolFormatterInterface::class, $this->formatter);
    }

    /**
     * @test
     * @dataProvider \Darsyn\IP\Tests\DataProvider\Formatter\ConsistentFormatter::getValidBinarySequences()
     */
    public function testFormatterReturnsCorrectProtocolString($value, $expected)
    {
        $this->assertSame($expected, $this->formatter->ntop($value));
    }

    /**
     * @test
     * @expectedException \Darsyn\IP\Exception\Formatter\FormatException
     * @dataProvider \Darsyn\IP\Tests\DataProvider\Formatter\ConsistentFormatter::getInvalidBinarySequences()
     */
    public function testFormatterThrowsExceptionOnInvalidBinarySequences($value)
    {
        try {
            $this->formatter->ntop($value);
        } catch (FormatException $e) {
            $this->assertSame($value, $e->getSuppliedBinary());
            throw $e;
        }
        $this->fail();
    }
}
