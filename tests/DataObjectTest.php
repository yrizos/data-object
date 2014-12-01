<?php

namespace DataObjectTest;

use DataObject\DataObject;

class DataObjectTest extends \PHPUnit_Framework_TestCase
{

    private $data = [];
    private $dto;

    public function setUp()
    {
        for ($i = 0; $i < 5; $i++) $this->data['key' . $i] = 'value' . $i;

        $this->dto = new DataObject();
        $this->dto->setData($this->data);
    }

    public function testSetGetData()
    {
        $dto = new DataObject();
        $dto->setData($this->data);
        $this->assertEquals($this->data, $dto->getData());
    }

    public function testOffsetSetGet()
    {
        $dto = new DataObject();

        foreach ($this->data as $key => $value) {
            $dto[$key] = $value;
            $this->assertEquals($value, $dto[$key]);
        }
    }

    public function testMagicSetGet()
    {
        $dto = new DataObject();

        foreach ($this->data as $key => $value) {
            $dto->$key = $value;
            $this->assertEquals($value, $dto->$key);
        }
    }

    public function testIterator()
    {
        foreach ($this->dto as $key => $value) {
            $this->assertEquals($this->data[$key], $value);
        }
    }

    public function testOffsetIssetUnset()
    {
        $this->assertTrue(isset($this->dto['key2']));
        unset($this->dto['key2']);
        $this->assertFalse(isset($this->dto['key2']));
    }

    public function testValues()
    {
        $this->assertEquals(array_values($this->data), $this->dto->values());
    }

    public function testKeys()
    {
        $this->assertEquals(array_keys($this->data), $this->dto->keys());
    }

    public function testCount()
    {
        $this->assertEquals(count($this->data), count($this->dto));
    }

    public function testSerialization()
    {
        $s = serialize($this->dto);
        $o = unserialize($s);

        $this->assertEquals($this->dto, $o);
    }
}