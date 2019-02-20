<?php
/*
 * This code is part of the aesonus/test-lib package.
 * This software is licensed under the MIT License. Please see LICENSE for more details.
 */

namespace Aesonus\TestLib\Tests;

use Aesonus\TestLib\PHPUnit\ConstraintArrayContainsValues;
use PHPUnit\Framework\TestCase;

/**
 * Tests the ConstraintArrayContainsValuesTest class
 *
 * @author Aesonus <corylcomposinger at gmail.com>
 */
class ConstraintArrayContainsValuesTest extends TestCase
{

    public $testObj;

    protected function setUp(): void
    {
        $this->testObj = new ConstraintArrayContainsValues([4, 'hi', 3.141]);
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
                [4, 'hi', 3.141]
            ],
            'not in same order' => [
                ['hi', 3.141, 4]
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
        $this->expectExceptionMessage('has only array values ');
        try {
            $actual = $this->testObj->evaluate($other);
        } catch (\PHPUnit\Framework\ExpectationFailedException $ex) {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex);
        }
    }

    /**
     * Data Provider
     */
    public function evaluateReturnsFalseOnFailureDataProvider()
    {
        return [
            'not enough' => [
                [4, 'hi']
            ],
            'too many' => [
                ['hi', 3.141, 4, 23]
            ]
        ];
    }
}
