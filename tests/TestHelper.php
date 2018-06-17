<?php
/*
 * This code is part of the aesonus/test-lib package.
 * This software is licensed under the MIT License. Please see LICENSE for more details.
 */

namespace Aesonus\TestLib\Tests;

/**
 * This class just defines some code to make testing a little easier
 *
 * @author Aesonus <corylcomposinger at gmail.com>
 */
class TestHelper
{
    protected $testProtectedProperty = 'expected';
    private $testPrivateProperty = 3.141;
    static protected $testStaticProtectedProperty = 'expected static';
    static private $testStaticPrivateProperty = 3.14159;
    
    public function __construct()
    {
        call_user_func_array([$this, BaseTestCaseTest::$methodToInvoke], func_get_args());
    }
    
    protected function testMethod()
    {
        
    }
}
