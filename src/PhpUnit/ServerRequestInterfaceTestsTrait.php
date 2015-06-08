<?php

namespace Maks3w\Psr7Assertions\PhpUnit;

use PHPUnit_Framework_Assert as Assert;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Provide PHPUnit test methods for Psr\Http\Message\ServerRequestInterface constraints.
 */
trait ServerRequestInterfaceTestsTrait
{
    use RequestInterfaceTestsTrait;

    // Test methods for default/empty instances

    public function testServerRequestImplementsInterface()
    {
        Assert::assertInstanceOf('Psr\Http\Message\ServerRequestInterface', $this->createDefaultServerRequest());
    }

    public function testValidDefaultServerParams()
    {
        $message = $this->createDefaultServerRequest();
        $serverParams = $message->getServerParams();

        Assert::assertInternalType('array', $serverParams, 'getServerParams must return an array');
    }

    public function testValidDefaultCookieParams()
    {
        $message = $this->createDefaultServerRequest();
        $cookieParams = $message->getCookieParams();

        Assert::assertInternalType('array', $cookieParams, 'getCookieParams must return an array');
    }

    public function testValidDefaultQueryParams()
    {
        $message = $this->createDefaultServerRequest();
        $queryParams = $message->getQueryParams();

        Assert::assertInternalType('array', $queryParams, 'getQueryParams must return an array');
    }

    public function testValidDefaultUploadedFiles()
    {
        $message = $this->createDefaultServerRequest();
        $uploadedFiles = $message->getUploadedFiles();

        Assert::assertInternalType('array', $uploadedFiles, 'getUploadedFiles must return an array');
        Assert::assertEmpty($uploadedFiles, 'an empty array MUST be returned if no data is present');
    }

    public function testValidDefaultParsedBody()
    {
        $message = $this->createDefaultServerRequest();
        $parsedBody = $message->getParsedBody();

        Assert::assertNull($parsedBody);
    }

    public function testValidNotExistsAttribute()
    {
        $message = $this->createDefaultServerRequest();
        $attribute = $message->getAttribute('not exists');

        Assert::assertNull($attribute, 'MUST return the argument $default if the attribute does not exist');
    }

    public function testValidNotExistsAttributeCustomDefault()
    {
        $message = $this->createDefaultServerRequest();

        $default = 'custom';
        $attribute = $message->getAttribute('not exists', $default);

        Assert::assertEquals($default, $attribute, 'MUST return the argument $default if the attribute does not exist');
    }

    // Test methods for change instances status

    /**
     * @dataProvider validAttributeProvider
     *
     * @param string $attributeName
     * @param string|string[] $attributeValue
     * @return void
     */
    public function testValidWithAttribute($attributeName, $attributeValue)
    {
        $message = $this->createDefaultServerRequest();
        $messageClone = clone $message;

        $newMessage = $message->withAttribute($attributeName, $attributeValue);

        $this->assertImmutable($messageClone, $message, $newMessage);

        Assert::assertEquals(
            $attributeValue,
            $newMessage->getAttribute($attributeName),
            'getAttribute does not match attribute set in withAttribute'
        );
    }

    /**
     * @dataProvider validAttributeProvider
     *
     * @param string $attributeName
     * @param string|string[] $attributeValue
     * @param string[] $expectedAttributeValue
     * @return void
     */
    public function testGetAttributes($attributeName, $attributeValue, $expectedAttributeValue)
    {
        $message = $this->createDefaultServerRequest();

        $newMessage = $message->withAttribute($attributeName, $attributeValue);

        Assert::assertEquals($expectedAttributeValue, $newMessage->getAttributes());
    }

    /**
     * @dataProvider validAttributeProvider
     *
     * @param string $attributeName
     * @param string|string[] $attributeValue
     * @return void
     */
    public function testWithoutAttribute($attributeName, $attributeValue)
    {
        $message = $this->createDefaultServerRequest();

        $messageWithAttribute = $message->withAttribute($attributeName, $attributeValue);
        $messageClone = clone $messageWithAttribute;

        $newMessage = $messageWithAttribute->withoutAttribute($attributeName);

        $this->assertImmutable($messageClone, $messageWithAttribute, $newMessage);
        Assert::assertEquals($message, $newMessage);
    }

    public function validAttributeProvider()
    {
        return [
            // Description => [attribute name, attribute value, getAttributes()],
            'Basic: value' => ['Basic', 'value', ['Basic' => 'value']],
            'array value' => ['Basic', ['value'], ['Basic' => ['value']]],
            'two value' => ['Basic', ['value1', 'value2'], ['Basic' => ['value1', 'value2']]],
        ];
    }

    /**
     * @return ServerRequestInterface
     */
    abstract protected function createDefaultServerRequest();

    protected function createDefaultRequest()
    {
        return $this->createDefaultServerRequest();
    }
}
