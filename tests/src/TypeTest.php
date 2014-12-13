<?php

namespace DataObjectTest;

use DataObject\Type;

class TypeTest extends \PHPUnit_Framework_TestCase
{

    public function testRaw()
    {
        $type = Type::factory('raw');

        $this->assertInstanceOf("DataObject\\Type\\RawType", $type);

        $data = [
            1,
            true,
            false,
            'hello world',
            $type
        ];

        foreach ($data as $value) {
            $this->assertTrue($type->validate($value));
            $this->assertSame($value, $type->filter($value));
        }
    }

    public function testString()
    {
        $type = Type::factory('string');

        $this->assertInstanceOf("DataObject\\Type\\StringType", $type);

        $this->assertTrue($type->validate('hello world'));

        $this->assertFalse($type->validate(''));
        $this->assertFalse($type->validate(true));
        $this->assertFalse($type->validate(false));
        $this->assertFalse($type->validate(null));
    }

    public function testInteger()
    {
        $type = Type::factory('integer');

        $this->assertInstanceOf("DataObject\\Type\\IntegerType", $type);

        $this->assertTrue($type->validate(1));
        $this->assertTrue($type->validate('-1'));

        $this->assertFalse($type->validate('hello world'));
        $this->assertFalse($type->validate(true));
        $this->assertFalse($type->validate(false));
        $this->assertFalse($type->validate(null));

        $this->assertSame(-1, $type->filter('-1'));
        $this->assertSame(2, $type->filter('2'));
    }

    public function testBoolean()
    {
        $type = Type::factory('bool');

        $this->assertInstanceOf("DataObject\\Type\\BooleanType", $type);

        $this->assertTrue($type->validate(true));
        $this->assertTrue($type->validate(false));
        $this->assertTrue($type->validate('true'));
        $this->assertTrue($type->validate('false'));
        $this->assertTrue($type->validate(1));
        $this->assertTrue($type->validate(0));

        $this->assertFalse($type->validate(null));
        $this->assertFalse($type->validate('hello word'));

        $this->assertSame(true, $type->filter('true'));
        $this->assertSame(false, $type->filter('false'));
        $this->assertSame(true, $type->filter(1));
        $this->assertSame(false, $type->filter(0));
    }

    public function testArray()
    {
        $type = Type::factory('array');

        $this->assertInstanceOf("DataObject\\Type\\ArrayType", $type);

        $this->assertTrue($type->validate([]));
        $this->assertTrue($type->validate([1, 2, 3]));

        $this->assertFalse($type->validate(null));
        $this->assertFalse($type->validate('hello word'));

        $this->assertSame([], $type->filter([]));
        $this->assertSame([1, 2, 3], $type->filter([1, 2, 3]));
    }

    public function testSerialized()
    {
        $type = Type::factory('serialized');

        $this->assertInstanceOf("DataObject\\Type\\SerializedType", $type);

        $data = [
            1,
            true,
            false,
            'hello world',
            $type
        ];

        foreach ($data as $value) {
            $serialized = serialize($value);

            $this->assertTrue($type->validate($value));
            $this->assertSame($serialized, $type->filter($value));
        }
    }

    public function testEmail()
    {
        $type = Type::factory('email');

        $this->assertInstanceOf("DataObject\\Type\\EmailType", $type);

        $this->assertTrue($type->validate('username@example.com'));
        $this->assertFalse($type->validate('hello world'));

        $this->assertSame('username@example.com', $type->filter('username@example.com'));
        $this->assertFalse($type->filter('hello world'));
    }

    public function testDate()
    {
        $type = Type::factory('DateTime');

        $this->assertInstanceOf("DataObject\\Type\\DateType", $type);

        $time     = time();
        $string   = date('Y-m-d');
        $datetime = new \DateTime();

        $this->assertTrue($type->validate($time));
        $this->assertTrue($type->validate($string));
        $this->assertTrue($type->validate($datetime));

        $this->assertInstanceOf('DateTime', $type->filter($time));
        $this->assertInstanceOf('DateTime', $type->filter($string));
        $this->assertInstanceOf('DateTime', $type->filter($datetime));
    }

    public function testAlnum()
    {
        $type = Type::factory('Alphanumeric');

        $this->assertInstanceOf("DataObject\\Type\\AlnumType", $type);

        $this->assertTrue($type->validate(1234));
        $this->assertTrue($type->validate('abc'));
        $this->assertTrue($type->validate('abc1234'));

        $this->assertInternalType('string', $type->filter(1234));
    }

    public function testFloat()
    {
        $type = Type::factory('float');

        $this->assertInstanceOf("DataObject\\Type\\FloatType", $type);

        $this->assertTrue($type->validate(3));
        $this->assertTrue($type->validate(3.14));
        $this->assertTrue($type->validate('3.14'));

        $this->assertInternalType('float', $type->filter(3));
        $this->assertInternalType('float', $type->filter('3.14'));
    }

    public function testIp()
    {
        $type = Type::factory('ip');

        $this->assertInstanceOf("DataObject\\Type\\IpType", $type);

        $this->assertTrue($type->validate('127.0.0.1'));
        $this->assertFalse($type->validate('Hello World'));
    }

    public function testUrl()
    {
        $type = Type::factory('url');

        $this->assertInstanceOf("DataObject\\Type\\UrlType", $type);

        $this->assertTrue($type->validate('www.example.com'));
        $this->assertTrue($type->validate('example.com'));
        $this->assertTrue($type->validate('http://www.example.com'));
        $this->assertTrue($type->validate('https://www.example.com'));
        $this->assertTrue($type->validate('http://example.com'));
        $this->assertTrue($type->validate('https://example.com'));

        $this->assertFalse($type->validate('Hello World'));
        $this->assertFalse($type->validate('.example.com'));
        $this->assertFalse($type->validate('http:/www.example.com'));
    }
}