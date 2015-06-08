<?php

use Maks3w\Psr7Assertions\PhpUnit\RequestInterfaceTestsTrait;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Diactoros\Request;

class RequestTest extends TestCase
{
    use RequestInterfaceTestsTrait;

    protected function createDefaultRequest()
    {
        return new Request();
    }
}
