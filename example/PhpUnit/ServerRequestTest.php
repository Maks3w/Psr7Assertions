<?php

use Maks3w\Psr7Assertions\PhpUnit\ServerRequestInterfaceTestsTrait;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Diactoros\ServerRequest;

class ServerRequestTest extends TestCase
{
    use ServerRequestInterfaceTestsTrait;

    protected function createDefaultServerRequest()
    {
        return new ServerRequest();
    }
}
