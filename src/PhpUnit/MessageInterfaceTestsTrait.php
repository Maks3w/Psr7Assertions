<?php

namespace Maks3w\Psr7Assertions\PhpUnit;

use PHPUnit_Framework_Assert as Assert;
use Psr\Http\Message\MessageInterface;

/**
 * Provide PHPUnit test methods for Psr\Http\Message\MessageInterface constraints.
 */
trait MessageInterfaceTestsTrait
{
    // Test methods for default/empty instances

    public function testMessageImplementsInterface()
    {
        Assert::assertInstanceOf('Psr\Http\Message\MessageInterface', $this->createDefaultMessage());
    }

    public function testValidDefaultProtocolVersion()
    {
        $message = $this->createDefaultMessage();
        $version = $message->getProtocolVersion();

        Assert::assertInternalType('string', $version, 'getProtocolVersion must return a string');
        Constraint\HttpProtocolVersion::assertValid($version);
    }

    public function testValidDefaultHeaders()
    {
        $message = $this->createDefaultMessage();
        $headers = $message->getHeaders();

        Assert::assertInternalType('array', $headers, "getHeaders an associative array of the message's headers");
        foreach ($headers as $name => $values) {
            Assert::assertInternalType('string', $name, 'Each key MUST be a header name');
            $this->assertValidHeaderValue($values);
        }
    }

    public function testValidNonExistHeader()
    {
        $message = $this->createDefaultMessage();
        $values = $message->getHeader('not exist');

        $this->assertValidHeaderValue($values);
    }

    public function testValidNonExistHeaderLine()
    {
        $message = $this->createDefaultMessage();
        $headerLine = $message->getHeaderLine('not exist');

        Assert::assertInternalType('string', $headerLine, 'getHeaderLine must return a string');
        Assert::assertEmpty(
            $headerLine,
            'If the header does not appear in the message, this method MUST return an empty string'
        );
    }

    public function testValidDefaultBody()
    {
        $message = $this->createDefaultMessage();
        $body = $message->getBody();

        Assert::assertInstanceOf(
            'Psr\Http\Message\StreamInterface',
            $body,
            'getBody must return instance of Psr\Http\Message\StreamInterface'
        );
    }

    // Test methods for change instances status

    /**
     * @dataProvider validProtocolVersionProvider
     *
     * @param string $expectedVersion
     * @return void
     */
    public function testValidWithProtocolVersion($expectedVersion)
    {
        $message = $this->createDefaultMessage();
        $messageClone = clone $message;

        $newMessage = $message->withProtocolVersion($expectedVersion);

        $this->assertImmutable($messageClone, $message, $newMessage);

        Assert::assertEquals(
            $expectedVersion,
            $newMessage->getProtocolVersion(),
            'getProtocolVersion does not match version set in withProtocolVersion'
        );
    }

    public function validProtocolVersionProvider()
    {
        return [
            // Description => [version],
            '1.0' => ['1.0'],
            '1.1' => ['1.1'],
        ];
    }

    /**
     * @dataProvider validHeaderProvider
     *
     * @param string $headerName
     * @param string|string[] $headerValue
     * @param string[] $expectedHeaderValue
     * @return void
     */
    public function testValidWithHeader($headerName, $headerValue, $expectedHeaderValue)
    {
        $message = $this->createDefaultMessage();
        $messageClone = clone $message;

        $newMessage = $message->withHeader($headerName, $headerValue);

        $this->assertImmutable($messageClone, $message, $newMessage);

        Assert::assertEquals(
            $expectedHeaderValue,
            $newMessage->getHeader($headerName),
            'getHeader does not match header set in withHeader'
        );
    }

    /**
     * @dataProvider validHeaderProvider
     *
     * @param string $headerName
     * @param string|string[] $headerValue
     * @param string[] $expectedHeaderValue
     * @return void
     */
    public function testValidWithAddedHeader($headerName, $headerValue, $expectedHeaderValue)
    {
        $message = $this->createDefaultMessage();
        $messageClone = clone $message;

        $newMessage = $message->withAddedHeader($headerName, $headerValue);

        $this->assertImmutable($messageClone, $message, $newMessage);

        Assert::assertEquals(
            $expectedHeaderValue,
            $newMessage->getHeader($headerName),
            'getHeader does not match header set in withAddedHeader'
        );
    }

    /**
     * @dataProvider validHeaderProvider
     *
     * @param string $headerName
     * @param string|string[] $headerValue
     * @return void
     */
    public function testHasHeader($headerName, $headerValue)
    {
        $message = $this->createDefaultMessage();

        Assert::assertFalse($message->hasHeader($headerName));

        $newMessage = $message->withHeader($headerName, $headerValue);

        Assert::assertTrue($newMessage->hasHeader($headerName));
    }

    /**
     * @dataProvider validHeaderProvider
     *
     * @param string $headerName
     * @param string|string[] $headerValue
     * @param string[] $expectedHeaderValue
     * @param string $expectedHeaderLine
     * @return void
     */
    public function testGetHeaderLine($headerName, $headerValue, $expectedHeaderValue, $expectedHeaderLine)
    {
        $message = $this->createDefaultMessage();

        $newMessage = $message->withHeader($headerName, $headerValue);

        Assert::assertEquals($expectedHeaderLine, $newMessage->getHeaderLine($headerName));
    }

    /**
     * @dataProvider validHeaderProvider
     *
     * @param string $headerName
     * @param string|string[] $headerValue
     * @param string[] $expectedHeaderValue
     * @return void
     */
    public function testGetHeaders($headerName, $headerValue, $expectedHeaderValue)
    {
        $message = $this->createDefaultMessage();

        $newMessage = $message->withHeader($headerName, $headerValue);

        Assert::assertEquals([$headerName => $expectedHeaderValue], $newMessage->getHeaders());
    }

    /**
     * @dataProvider validHeaderProvider
     *
     * @param string $headerName
     * @param string|string[] $headerValue
     * @return void
     */
    public function testWithoutHeader($headerName, $headerValue)
    {
        $message = $this->createDefaultMessage();

        $messageWithHeader = $message->withHeader($headerName, $headerValue);
        $messageClone = clone $messageWithHeader;
        Assert::assertTrue($messageWithHeader->hasHeader($headerName));

        $newMessage = $messageWithHeader->withoutHeader($headerName);

        $this->assertImmutable($messageClone, $messageWithHeader, $newMessage);
        Assert::assertFalse($newMessage->hasHeader($headerName));
        Assert::assertEquals($message, $newMessage);
    }

    public function validHeaderProvider()
    {
        return [
            // Description => [header name, header value, getHeader(), getHeaderLine()],
            'Basic: value' => ['Basic', 'value', ['value'], 'value'],
            'array value' => ['Basic', ['value'], ['value'], 'value'],
            'two value' => ['Basic', ['value1', 'value2'], ['value1', 'value2'], 'value1,value2'],
        ];
    }

    public function testWithBody()
    {
        $message = $this->createDefaultMessage();
        $messageClone = clone $message;

        $expectedBody = $this->getMock('Psr\Http\Message\StreamInterface');
        $newMessage = $message->withBody($expectedBody);

        $this->assertImmutable($messageClone, $message, $newMessage);

        Assert::assertEquals(
            $expectedBody,
            $newMessage->getBody(),
            'getBody does not match body set in withBody'
        );
    }

    /**
     * @return MessageInterface
     */
    abstract protected function createDefaultMessage();

    /**
     * DRY Assert header values.
     *
     * @param string[] $values
     * @return void
     */
    protected function assertValidHeaderValue($values)
    {
        Assert::assertInternalType('array', $values, 'header values MUST be an array of strings');
        Assert::assertContainsOnly('string', $values, 'MUST be an array of strings');
    }

    /**
     * @param object $messageClone
     * @param object $message
     * @param object $newMessage
     * @return void
     */
    protected function assertImmutable($messageClone, $message, $newMessage)
    {
        Assert::assertEquals($messageClone, $message, 'Original message must be immutable');
        Constraint\Immutable::assertImmutable($message, $newMessage);
    }
}
