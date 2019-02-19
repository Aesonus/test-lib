<?php
/*
 * This code is part of the aesonus/test-lib package.
 * This software is licensed under the MIT License. Please see LICENSE for more details.
 */

namespace Aesonus\TestLib\PHPUnit;

/**
 * Asserts that an array has the specified values in no particular order and nothing else
 *
 * @author Aesonus <corylcomposinger at gmail.com>
 */
class ConstraintArrayContainsValues extends \PHPUnit\Framework\Constraint\Constraint
{
    /**
     *
     * @var array
     */
    private $expected;

    public function __construct(array $expected)
    {
        $this->expected = $expected;
    }

    protected function matches($other): bool
    {
        $copy_of_other = $other;
        $results = array_filter($this->expected, function ($value) use ($other, &$copy_of_other) {
            if (in_array($value, $other, true)) {
                array_pop($copy_of_other);
                return false;
            } else {
                return true;
            }
        });
        return empty($results) && empty($copy_of_other);
    }

    public function toString(): string
    {

        return 'has only array values ' . $this->exporter()->export($this->expected);
    }
}
