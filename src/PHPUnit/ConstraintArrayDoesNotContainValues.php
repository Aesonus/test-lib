<?php
/*
 * This code is part of the aesonus/test-lib package.
 * This software is licensed under the MIT License. Please see LICENSE for more details.
 */
namespace Aesonus\TestLib\PHPUnit;

use PHPUnit\Framework\Constraint\Constraint;

/**
 * Asserts that an array does not contain the given values
 *
 * @author Aesonus <corylcomposinger at gmail.com>
 */
class ConstraintArrayDoesNotContainValues extends Constraint
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
        $expected = $this->expected;
        $results = array_filter($other, function ($value) use ($expected) {
            return !array_search($value, $expected, true);
        });
        return count($results) >= count($other);
    }
    
    public function toString(): string
    {
        return 'does not contain array values ' . $this->exporter()->export($this->expected);
    }
}
