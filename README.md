# PSR-7 Assertions

[![Build Status](https://travis-ci.org/Maks3w/Psr7Assertions.svg?branch=master)](https://travis-ci.org/Maks3w/Psr7Assertions)
[![Coverage Status](https://coveralls.io/repos/Maks3w/Psr7Assertions/badge.svg?branch=master)](https://coveralls.io/r/Maks3w/Psr7Assertions?branch=master)

Test your log messages are compliant with the [PSR-7 (HTTP message interfaces) specification](http://www.php-fig.org/psr/psr-7/)

## Installing via Composer

You can use [Composer](https://getcomposer.org) .

```bash
composer require maks3w/psr7-assertions
```

## Usage in PHPUnit

There are many traits for provide predefined helper functions for assert specific interface constraints.

- [MessageInterfaceTestsTrait](src/PhpUnit/MessageInterfaceTestsTrait.php) For test MessageInterface implementations.
- [RequestInterfaceTestsTrait](src/PhpUnit/RequestInterfaceTestsTrait.php) For test RequestInterface implementations.
- [ResponseInterfaceTestsTrait](src/PhpUnit/ResponseInterfaceTestsTrait.php) For test ResponseInterface implementations.
- [ServerRequestInterfaceTestsTrait](src/PhpUnit/ServerRequestInterfaceTestsTrait.php) For test ServerRequestInterface implementations.

See examples at [example/PhpUnit](example/PhpUnit)

## License

  Code licensed under BSD 2 clauses terms & conditions.

  See [LICENSE.txt](LICENSE.txt) for more information.
