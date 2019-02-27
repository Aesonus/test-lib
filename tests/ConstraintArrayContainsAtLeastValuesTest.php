<?php
/*
 * This code is part of the aesonus/test-lib package.
 * This software is licensed under the MIT License. Please see LICENSE for more details.
 */

namespace Aesonus\TestLib\Tests;

use Aesonus\TestLib\PHPUnit\ConstraintArrayContainsAtLeastValues;
use Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

/**
 * Tests the ConstraintArrayContainsValuesTest class
 *
 * @author Aesonus <corylcomposinger at gmail.com>
 */
class ConstraintArrayContainsAtLeastValuesTest extends TestCase
{

    public $testObj;

    protected function setUp(): void
    {
        $this->testObj = new ConstraintArrayContainsAtLeastValues([4, 'hi', 3.141, 67, 'hello world']);
    }

    /**
     * @test
     * @dataProvider evaluateReturnsTrueOnSuccessDataProvider
     */
    public function evaluateReturnsTrueOnSuccess($other)
    {
        $actual = $this->testObj->evaluate($other, '', true);
        $this->assertTrue($actual);
    }

    /**
     * Data Provider
     */
    public function evaluateReturnsTrueOnSuccessDataProvider()
    {
        return [
            'in same order' => [
                ['hi', 'hello world', 67]
            ],
            'not in same order' => [
                ['hi', 4]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider evaluateReturnsFalseOnFailureDataProvider
     */
    public function evaluateReturnsFalseOnFailure($other)
    {
        $actual = $this->testObj->evaluate($other, '', true);
        $this->assertFalse($actual);
    }

    /**
     * @test
     * @dataProvider evaluateReturnsFalseOnFailureDataProvider
     */
    public function evaluateThrowsExceptionOnFailure($other)
    {
        $this->expectExceptionMessage('contains at least array values ');
        try {
            $actual = $this->testObj->evaluate($other);
        } catch (ExpectationFailedException $ex) {
            throw new Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Data Provider
     */
    public function evaluateReturnsFalseOnFailureDataProvider()
    {
        return [
            'not enough' => [
                ['hi', 3.141, 4, 23]
            ],
            'too many' => [[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]],
        ];
    }
}
