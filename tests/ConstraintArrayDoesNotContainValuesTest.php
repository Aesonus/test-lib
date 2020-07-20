<?php
/*
 * This code is part of the aesonus/test-lib package.
 * This software is licensed under the MIT License. Please see LICENSE for more details.
 */
namespace Aesonus\TestLib\Tests;

use Aesonus\TestLib\PHPUnit\ConstraintArrayDoesNotContainValues;
use Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Tests the ConstraintArrayDoesNotContainValues
 *
 * @author Aesonus <corylcomposinger at gmail.com>
 */
class ConstraintArrayDoesNotContainValuesTest extends TestCase
{
    public $testObj;
    
    protected function setUp(): void
    {
        $this->testObj = new ConstraintArrayDoesNotContainValues([4, 'hi', 3.141]);
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
            'same number of elements' => [
                ['not', 34, 3.14159]
            ],
            'less than number of elements' => [
                ['not', 3.14159]
            ],
            'more than number of elements' => [
                ['not', 34, 3.14159, new stdClass()]
            ],
            'empty' => [array()],
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
        $this->expectExceptionMessage('does not contain array values ');
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
            'contains one of' => [
                ['hi']
            ],
            'contains one of and others' => [
                [3.141, 'others']
            ],
            'contains some of' => [
                [3.141, 4]
            ],
            'contains some of and others' => [
                ['hi', 'others', 3.141]
            ],
            'contains all of' => [
                ['hi', 4, 3.141]
            ],
            'contains all of and others' => [
                [4, 'others', 3.141, new stdClass(), 'hi']
            ],
        ];
    }
}
