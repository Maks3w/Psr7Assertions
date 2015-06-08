<?php

namespace Maks3w\Psr7AssertionsTest\PhpUnit\Constraint;

use Maks3w\Psr7Assertions\PhpUnit\Constraint\HttpProtocolVersion;
use PHPUnit_Framework_ExpectationFailedException as ExpectationFailedException;
use PHPUnit_Framework_TestCase as TestCase;
use PHPUnit_Framework_TestFailure as TestFailure;

class HttpProtocolVersionTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_Constraint
     */
    protected $constraint;

    protected function setUp()
    {
        $this->constraint = new HttpProtocolVersion();
    }

    public function testConstraintDefinition()
    {
        $this->assertEquals(1, count($this->constraint));
        $this->assertEquals(
            'is a valid HTTP protocol version number',
            $this->constraint->toString()
        );
    }

    /**
     * @dataProvider validProtocolVersionProvider
     *
     * @param string $version
     *
     * @return void
     */
    public function testValidConstraint($version)
    {
        $this->assertTrue($this->constraint->evaluate($version, '', true));

        HttpProtocolVersion::assertValid($version);

        $this->assertTrue(true);
    }

    /**
     * @dataProvider invalidProtocolVersionProvider
     *
     * @param mixed $version
     *
     * @return void
     */
    public function testInvalidConstraint($version)
    {
        $this->assertFalse($this->constraint->evaluate($version, '', true));

        $assertValidExpectationFailedException = function ($version, $e) {
            self::assertStringMatchesFormat(
                "Failed asserting that {$version}%S is a valid HTTP protocol version number.\n",
                TestFailure::exceptionToString($e)
            );
        };

        try {
            $this->constraint->evaluate($version);
            $this->fail('Expected ExpectationFailedException to be thrown');
        } catch (ExpectationFailedException $e) {
            $assertValidExpectationFailedException($version, $e);
        }

        try {
            HttpProtocolVersion::assertValid($version);
            $this->fail('Expected ExpectationFailedException to be thrown');
        } catch (ExpectationFailedException $e) {
            $assertValidExpectationFailedException($version, $e);
        }
    }

    public function validProtocolVersionProvider()
    {
        return [
            '1.0' => ['1.0'],
            '1.1' => ['1.1'],
        ];
    }

    public function invalidProtocolVersionProvider()
    {
        return [
            'empty' => [''],
            'decimal 1.0' => [1.0],
            'decimal 1.1' => [1.1],
        ];
    }
}
