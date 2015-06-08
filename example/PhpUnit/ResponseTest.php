<?php

use Maks3w\Psr7Assertions\PhpUnit\ResponseInterfaceTestsTrait;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Diactoros\Response;

class ResponseTest extends TestCase
{
    use ResponseInterfaceTestsTrait;

    protected function createDefaultResponse()
    {
        return new Response();
    }
}
