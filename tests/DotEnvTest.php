<?php


use Felix\DotEnv;
use PHPUnit\Framework\TestCase;

class DotEnvTest extends TestCase
{

    public function testIfValuesAreInjected(): void
    {
        $this->assertEquals('Felix', $_SERVER['NAME']);
        $this->assertEquals('Felix', $_ENV['NAME']);
        $this->assertEquals('Felix', getenv('NAME'));
    }

    public function testConcatenationWhenNeeded(): void
    {
        $this->assertEquals('HelloFelix', $_SERVER['DUMMY']);
        $this->assertEquals('HelloFelix', $_ENV['DUMMY']);
        $this->assertEquals('HelloFelix', getenv('DUMMY'));
    }

    public function testConcatenationWhenUnneeded(): void
    {
        $this->assertEquals('bar;\${ENV}ENV', $_SERVER['FOO']);
        $this->assertEquals('bar;\${ENV}ENV', $_ENV['FOO']);
        $this->assertEquals('bar;\${ENV}ENV', getenv('FOO'));
    }

    public function testWithQuotes(): void {
        $this->assertEquals('foo', $_SERVER['MACHIN']);
        $this->assertEquals('foo', $_ENV['MACHIN']);
        $this->assertEquals('foo', getenv('MACHIN'));
    }

    public function testUppercasedValue(): void
    {
        $this->assertEquals('TESTS', $_SERVER['BADCASE']);
        $this->assertNull($_SERVER['bAdCASe']);

        $this->assertEquals('TESTS', $_ENV['BADCASE']);
        $this->assertNull($_ENV['bAdCASe']);

        $this->assertEquals('TESTS', getenv('BADCASE'));
        $this->assertFalse(getenv('bAdCASe'));
    }

    protected function setUp()
    {
        DotEnv::register(__DIR__ . '/.env.test');
    }
}