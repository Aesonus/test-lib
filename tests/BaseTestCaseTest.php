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
        $this->baseTestCase = $this->getMockForAbstractClass(BaseTestCase::class);
        parent::setUp();
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
