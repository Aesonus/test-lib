<?php
/*
 * This code is part of the aesonus/test-lib package.
 * This software is licensed under the MIT License. Please see LICENSE for more details.
 */

namespace Aesonus\TestLib\PHPUnit;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Asserts that an array has at least the specified values in no particular order
 *
 * @author Aesonus <corylcomposinger at gmail.com>
 */
class ConstraintArrayContainsAtLeastValues extends Constraint
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
        array_map(function ($value) use ($other, &$copy_of_other) {
            if (in_array($value, $other, true)) {
                array_pop($copy_of_other);
                return false;
            } else {
                return true;
            }
        }, $this->expected);
        return empty($copy_of_other);
    }

    public function toString(): string
    {

        return 'contains at least array values ' . $this->exporter()->export($this->expected);
    }
}
