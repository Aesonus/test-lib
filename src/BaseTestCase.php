<?php
/*
 * This code is part of the aesonus/test-lib package.
 * This software is licensed under the MIT License. Please see LICENSE for more details.
 * Some code was provided in PHPUnit documentation and is goverened by its license terms
 *
 */

namespace Aesonus\TestLib;

use Aesonus\TestLib\PHPUnit\ConstraintArrayContainsAtLeastValues;
use Aesonus\TestLib\PHPUnit\ConstraintArrayContainsValues;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;

/**
 * Description of BaseTestCase
 *
 * @author Aesonus <corylcomposinger at gmail.com>
 * @author Sebastian Bergmann <sebastian@phpunit.de>
 */
abstract class BaseTestCase extends TestCase
{
    /**
     * Asserts that the array has the expected values in no particular order and
     * nothing else.
     *
     * @param array $expected
     * @param mixed $actual
     * @param string $message
     * @throws AssertionFailedError
     */
    public static function assertArrayContainsValues(array $expected, $actual, $message = '')
    {
        static::assertThat($actual, new ConstraintArrayContainsValues($expected), $message);
    }

    /**
     * Asserts that the array has at least the expected values in no particular order
     *
     * @param array $expected
     * @param mixed $actual
     * @param string $message
     * @throws AssertionFailedError
     */
    public static function assertArrayContainsAtLeastValues(array $expected, $actual, $message = '')
    {
        static::assertThat($actual, new ConstraintArrayContainsAtLeastValues($expected), $message);
    }

    /**
     * Asserts that the array does not contain the expected values in no particular order
     *
     * @param array $expected
     * @param mixed $actual
     * @param string $message
     * @throws AssertionFailedError
     */
    public static function assertArrayDoesNotContainValues(array $expected, $actual, $message = '')
    {
        static::assertThat($actual, new PHPUnit\ConstraintArrayDoesNotContainValues($expected), $message);
    }
}
