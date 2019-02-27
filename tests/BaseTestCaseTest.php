<?php
/*
 * This code is part of the aesonus/test-lib package.
 * This software is licensed under the MIT License. Please see LICENSE for more details.
 */

namespace Aesonus\TestLib\Tests;

use Aesonus\TestLib\BaseTestCase;
use Aesonus\TestLib\Tests\TestHelper;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * Description of BaseTestCaseTest
 *
 * @author Aesonus <corylcomposinger at gmail.com>
 */
class BaseTestCaseTest extends TestCase
{

    /**
     *
     * @var BaseTestCase
     */
    public $baseTestCase;
    public $mockObject;
    public static $methodToInvoke = 'testMethod';

    protected function setUp(): void
    {
        \PHPUnit\Framework\Error\Notice::$enabled = false;
        $this->baseTestCase = $this->getMockForAbstractClass(BaseTestCase::class);
        $this->mockObject = $this->getMockBuilder(TestHelper::class)->setMethods([static::$methodToInvoke])->disableOriginalConstructor()
            ->getMock();
        //$this->mockObject->expects($this->once())->method(static::$methodToInvoke)->willReturn(true);
        parent::setUp();
    }

    public function parametersDataProvider()
    {
        return [
            [[NULL]],
            [['arg1', new \stdClass()]],
            [['arg1', new \stdClass(), 56]],
            [['arg1', new \stdClass(), 54.673]]
        ];
    }

    private function getMockExpectedParams($expected_params)
    {
        return array_map(function ($value) {
            return $this->equalTo($value);
        }, $expected_params);
    }

    /**
     * @test
     */
    public function testInvokeConstructorWithNoParametersWorks()
    {
        $this->mockObject->expects($this->once())->method(static::$methodToInvoke);
        $this->baseTestCase->invokeConstructor($this->mockObject);
    }

    /**
     * @test
     * @dataProvider parametersDataProvider
     */
    public function invokeConstructorWithParametersCallsTheRightMethod($expected_params)
    {
        $mock_expected_params = $this->getMockExpectedParams($expected_params);
        //Set expectation
        call_user_func_array([$this->mockObject->expects($this->once())->method(static::$methodToInvoke), 'with'], $mock_expected_params);
        $this->baseTestCase->invokeConstructor($this->mockObject, $expected_params);
    }

    /**
     * @test
     */
    public function testAssertArrayContainsValues()
    {
        BaseTestCase::assertArrayContainsValues(['hi', 'there'], ['there', 'hi']);

        $this->expectException(\Exception::class);

        try {
            BaseTestCase::assertArrayContainsValues(['hi', 'there'], ['hi']);
        } catch (AssertionFailedError $exc) {
            throw new \Exception();
        }
    }
}
