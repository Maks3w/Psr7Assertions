<?php

namespace Maks3w\Psr7Assertions\PhpUnit;

use PHPUnit_Framework_Assert as Assert;
use Psr\Http\Message\ResponseInterface;

/**
 * Provide PHPUnit test methods for Psr\Http\Message\ResponseInterface constraints.
 */
trait ResponseInterfaceTestsTrait
{
    use MessageInterfaceTestsTrait;

    // Test methods for default/empty instances

    public function testResponseImplementsInterface()
    {
        Assert::assertInstanceOf('Psr\Http\Message\ResponseInterface', $this->createDefaultResponse());
    }

    public function testValidDefaultStatusCode()
    {
        $message = $this->createDefaultResponse();
        $statusCode = $message->getStatusCode();

        Assert::assertInternalType('integer', $statusCode, 'getStatusCode must return an integer');
    }

    public function testValidDefaultReasonPhrase()
    {
        $message = $this->createDefaultResponse();
        $reasonPhrase = $message->getReasonPhrase();

        Assert::assertInternalType('string', $reasonPhrase, 'getReasonPhrase must return a string');
        Assert::assertEmpty($reasonPhrase, 'must return an empty string if none present');
    }

    // Test methods for change instances status

    public function testValidWithStatus()
    {
        $message = $this->createDefaultResponse();
        $messageClone = clone $message;

        $statusCode = 100;
        $reasonPhrase = 'example';

        $newMessage = $message->withStatus($statusCode, $reasonPhrase);

        $this->assertImmutable($messageClone, $message, $newMessage);

        Assert::assertEquals(
            $statusCode,
            $newMessage->getStatusCode(),
            'getStatusCode does not match code set in withStatus'
        );
        Assert::assertEquals(
            $reasonPhrase,
            $newMessage->getReasonPhrase(),
            'getReasonPhrase does not match code set in withStatus'
        );
    }

    /**
     * @return ResponseInterface
     */
    abstract protected function createDefaultResponse();

    protected function createDefaultMessage()
    {
        return $this->createDefaultResponse();
    }
}
