<?php
/*
 * This code is part of the aesonus/test-lib package.
 * This software is licensed under the MIT License. Please see LICENSE for more details.
 */

namespace Aesonus\TestLib\Tests;

use Aesonus\TestLib\Tests\TestHelper;

/**
 * Description of BaseTestCaseTest
 *
 * @author Aesonus <corylcomposinger at gmail.com>
 */
class BaseTestCaseTest extends \PHPUnit\Framework\TestCase
{

    /**
     *
     * @var \Aesonus\TestLib\BaseTestCase
     */
    public $baseTestCase;
    public $mockObject;
    public static $methodToInvoke = 'testMethod';

    protected function setUp(): void
    {
        $this->baseTestCase = $this->getMockForAbstractClass(\Aesonus\TestLib\BaseTestCase::class);
        $this->mockObject = $this->getMockBuilder(TestHelper::class)->setMethods([static::$methodToInvoke])->disableOriginalConstructor()
            ->getMock();
        //$this->mockObject->expects($this->once())->method(static::$methodToInvoke)->willReturn(true);
        parent::setUp();
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
    public function invokeMethodCallsTheRightMethod()
    {
        //Set expectation
        $this->mockObject->expects($this->once())->method(static::$methodToInvoke);
        $this->baseTestCase->invokeMethod($this->mockObject, static::$methodToInvoke);
    }

    /**
     * @test
     * @dataProvider parametersDataProvider
     */
    public function invokeMethodWithArgsCallsMethodWithArgs($expected_params)
    {
        $mock_expected_params = $this->getMockExpectedParams($expected_params);
        //Set expectation
        call_user_func_array([$this->mockObject->expects($this->once())->method(static::$methodToInvoke), 'with'], $mock_expected_params);
        $this->baseTestCase->invokeMethod($this->mockObject, static::$methodToInvoke, $expected_params);
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

    /**
     * @test
     */
    public function getProtectedPropertyValueGetsCorrectValueFromTestHelper()
    {
        $expected = 'expected';
        $this->assertEquals($expected, $this
                ->baseTestCase
                ->getPropertyValue($this->mockObject, 'testProtectedProperty')
        );
    }

    /**
     * @test
     */
    public function getPrivatePropertyValueGetsCorrectValueFromTestHelper()
    {
        $expected = 3.141;
        $mockObject = new TestHelper();
        $this->assertEquals($expected, $this
                ->baseTestCase
                ->getPropertyValue($mockObject, 'testPrivateProperty')
        );
    }

    /**
     * @test
     */
    public function setPrivatePropertyValueGetsCorrectValueFromTestHelper()
    {
        $expected = new \stdClass();
        $mockObject = new TestHelper();
        $method = 'testPrivateProperty';
        $this->baseTestCase->setPropertyValue($mockObject, $method, $expected);
        $this->assertEquals($expected, $this
                ->baseTestCase
                ->getPropertyValue($mockObject, $method)
        );
    }

    /**
     * @test
     */
    public function setProtectedPropertyValueGetsCorrectValueFromTestHelper()
    {
        $expected = new \stdClass();
        $mockObject = new TestHelper();
        $method = 'testProtectedProperty';
        $this->baseTestCase->setPropertyValue($mockObject, $method, $expected);
        $this->assertEquals($expected, $this
                ->baseTestCase
                ->getPropertyValue($mockObject, $method)
        );
    }

    /**
     * @test
     */
    public function getStaticProtectedPropertyValue()
    {
        $expected = 'expected static';
        $this->assertEquals($expected, $this->baseTestCase->getPropertyValue($this->mockObject, 'testStaticProtectedProperty'));
    }

    /**
     * @test
     */
    public function getStaticPrivatePropertyValue()
    {
        $expected = 3.14159;
        $test_helper = new TestHelper();
        $this->assertEquals($expected, $this->baseTestCase->getPropertyValue($test_helper, 'testStaticPrivateProperty'));
    }

    /**
     * @test
     */
    public function setStaticProtectedPropertyValueGetsCorrectValueFromTestHelper()
    {
        $expected = new \stdClass();
        $mockObject = new TestHelper();
        $method = 'testStaticProtectedProperty';
        $this->baseTestCase->setPropertyValue($mockObject, $method, $expected);
        $this->assertEquals($expected, $this
                ->baseTestCase
                ->getPropertyValue($mockObject, $method)
        );
    }

    /**
     * @test
     */
    public function setStaticPrivatePropertyValueGetsCorrectValueFromTestHelper()
    {
        $expected = 'new \stdClass()';
        $mockObject = new TestHelper();
        $method = 'testStaticPrivateProperty';
        $this->baseTestCase->setPropertyValue($mockObject, $method, $expected);
        $this->assertEquals($expected, $this
                ->baseTestCase
                ->getPropertyValue($mockObject, $method)
        );
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
}
