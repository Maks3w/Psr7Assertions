<?php

namespace Maks3w\Psr7Assertions\PhpUnit;

use PHPUnit_Framework_Assert as Assert;
use Psr\Http\Message\RequestInterface;

/**
 * Provide PHPUnit test methods for Psr\Http\Message\RequestInterface constraints.
 */
trait RequestInterfaceTestsTrait
{
    use MessageInterfaceTestsTrait;

    // Test methods for default/empty instances

    public function testRequestImplementsInterface()
    {
        Assert::assertInstanceOf('Psr\Http\Message\RequestInterface', $this->createDefaultRequest());
    }

    public function testValidDefaultRequestTarget()
    {
        $message = $this->createDefaultRequest();
        $target = $message->getRequestTarget();

        Assert::assertInternalType('string', $target, 'getRequestTarget must return a string');
        Assert::assertEquals(
            '/',
            $target,
            'If no URI is available, and no request-target has been specifically provided, this method MUST return the string "/"'
        );
    }

    public function testValidDefaultMethod()
    {
        $message = $this->createDefaultRequest();
        $target = $message->getMethod();

        Assert::assertInternalType('string', $target, 'getMethod must return a string');
    }

    public function testValidDefaultUri()
    {
        $message = $this->createDefaultRequest();
        $body = $message->getUri();

        Assert::assertInstanceOf(
            'Psr\Http\Message\UriInterface',
            $body,
            'getUri must return instance of Psr\Http\Message\UriInterface'
        );
    }

    // Test methods for change instances status

    /**
     * @dataProvider validRequestTargetProvider
     *
     * @param string $expectedRequestTarget
     *
     * @return void
     */
    public function testValidWithRequestTarget($expectedRequestTarget)
    {
        $request = $this->createDefaultRequest();
        $requestClone = clone $request;

        $newRequest = $request->withRequestTarget($expectedRequestTarget);

        $this->assertImmutable($requestClone, $request, $newRequest);

        Assert::assertEquals(
            $expectedRequestTarget,
            $newRequest->getRequestTarget(),
            'getRequestTarget does not match request target set in withRequestTarget'
        );
    }

    public function validRequestTargetProvider()
    {
        return [
            // Description => [request target],
            '*' => ['*'],
        ];
    }

    /**
     * @dataProvider validMethodProvider
     *
     * @param string $expectedMethod
     *
     * @return void
     */
    public function testValidWithMethod($expectedMethod)
    {
        $request = $this->createDefaultRequest();
        $requestClone = clone $request;

        $newRequest = $request->withMethod($expectedMethod);

        $this->assertImmutable($requestClone, $request, $newRequest);

        Assert::assertEquals(
            $expectedMethod,
            $newRequest->getMethod(),
            'getMethod does not match request target set in withMethod'
        );
    }

    public function validMethodProvider()
    {
        return [
            // Description => [request method],
            'GET' => ['GET'],
            'POST' => ['POST'],
            'PUT' => ['PUT'],
            'DELETE' => ['DELETE'],
            'PATCH' => ['PATCH'],
            'OPTIONS' => ['OPTIONS'],
        ];
    }

    public function testValidWithUri()
    {
        $request = $this->createDefaultRequest();
        $requestClone = clone $request;

        $uri = $this->getMock('Psr\Http\Message\UriInterface');

        $newRequest = $request->withUri($uri);

        $this->assertImmutable($requestClone, $request, $newRequest);

        Assert::assertEquals(
            $uri,
            $newRequest->getUri(),
            'getUri does not match request target set in withUri'
        );
    }

    /**
     * @return RequestInterface
     */
    abstract protected function createDefaultRequest();

    protected function createDefaultMessage()
    {
        return $this->createDefaultRequest();
    }
}
