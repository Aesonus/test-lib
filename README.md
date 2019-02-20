[![Build Status](https://travis-ci.org/Aesonus/test-lib.svg?branch=master)](https://travis-ci.org/Aesonus/test-lib)

# Test Lib

This package contains a base class for testing purposes. It also includes phpunit version 8, and a
virtual file system to mock the real file system.

## Installation

```bash
composer require aesonus/test-lib
```

## Usage

You can use this to assert that an array contains only the values in expected. The 
keys are completely disregarded.

Use inside your test cases

```php
class TestCase extends Aesonus\TestLib\BaseTestCase
{
    public function testCase() {
        $this->assertArrayContainsValues($expected, $actual);
    }
}
```

## Bugs

Feel free to email me with bug reports or open an issue