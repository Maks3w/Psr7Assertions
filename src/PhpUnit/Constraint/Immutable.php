<?php

namespace Maks3w\Psr7Assertions\PhpUnit\Constraint;

use PHPUnit_Framework_Assert as Assert;
use PHPUnit_Framework_Constraint as Constraint;

/**
 * Validate two objects are the same type but not the same instance.
 */
class Immutable extends Constraint
{
    /**
     * Asserts two objects are the same type but not the same instance.
     *
     * @param object $original
     * @param object $new
     * @param string $message
     */
    public static function assertImmutable($original, $new, $message = '')
    {
        Assert::assertThat($new, new self($original), $message);
    }

    /**
     * @var object
     */
    private $new;

    public function __construct($new)
    {
        parent::__construct();

        $this->new = $new;
    }

    protected function matches($other)
    {
        if (!($other instanceof $this->new)) {
            return false;
        }

        return ($other !== $this->new);
    }

    protected function failureDescription($other)
    {
        return sprintf(
            '%s and %s are different instances of the same class',
            get_class($this->new),
            get_class($other)
        );
    }

    public function toString()
    {
        return 'is immutable';
    }
}
