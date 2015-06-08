# PSR-7 Assertions

[![Build Status](https://travis-ci.org/Maks3w/Psr7Assertions.svg?branch=master)](https://travis-ci.org/Maks3w/Psr7Assertions)
[![Coverage Status](https://coveralls.io/repos/Maks3w/Psr7Assertions/badge.svg?branch=master)](https://coveralls.io/r/Maks3w/Psr7Assertions?branch=master)

Test if your HTTP messages are compliant with the [PSR-7 (HTTP message interfaces) specification](http://www.php-fig.org/psr/psr-7/).

## Installation

Use [Composer](https://getcomposer.org) to install this library:

```bash
composer require maks3w/psr7-assertions
```

## Usage in PHPUnit

`Psr7Assertions` provides following traits with helper functions for asserting interface constraints:

- [MessageInterfaceTestsTrait](src/PhpUnit/MessageInterfaceTestsTrait.php) for testing `MessageInterface` implementations.
- [RequestInterfaceTestsTrait](src/PhpUnit/RequestInterfaceTestsTrait.php) for testing `RequestInterface` implementations.
- [ResponseInterfaceTestsTrait](src/PhpUnit/ResponseInterfaceTestsTrait.php) for testing `ResponseInterface` implementations.
- [ServerRequestInterfaceTestsTrait](src/PhpUnit/ServerRequestInterfaceTestsTrait.php) for testing `ServerRequestInterface` implementations.

See examples at [example/PhpUnit](example/PhpUnit).

## License

  Code licensed under BSD 2 clauses terms & conditions.

  See [LICENSE.txt](LICENSE.txt) for more information.
