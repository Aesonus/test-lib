<?php
/*
 * This code is part of the aesonus/test-lib package.
 * This software is licensed under the MIT License. Please see LICENSE for more details.
 */

namespace Aesonus\TestLib;

/**
 * Description of BaseTestCase
 *
 * @author Aesonus <corylcomposinger at gmail.com>
 */
abstract class BaseTestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Call protected/private method of a class.
     *
     * @param object &$object    Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array  $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     */
    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
    
    /**
     * Get protected and private properties of an object
     * @param \StdClass $object
     * @param string $propertyName
     * @return mixed
     */
    public function getPropertyValue(&$object, $propertyName)
    {
        $reflection = new \ReflectionProperty(get_class($object), $propertyName);
        $reflection->setAccessible(true);
        return $reflection->getValue($object);
    }
    
    public function invokeConstructor(&$object, $args = [])
    {
        $as_class = get_class($object);
        (new \ReflectionClass($as_class))->getConstructor()->invokeArgs($object, $args);
    }
    
    public function setPropertyValue(&$object, $propertyName, $value, $as_static = false)
    {
        $reflection = new \ReflectionProperty(get_class($object), $propertyName);
        $reflection->setAccessible(true);
        $reflection->setValue($as_static === true ? NULL : $object, $value);
    }
}
