<?php

namespace DataObjectTest;

use DataObject\DataObject;

class DataObjectTest extends \PHPUnit_Framework_TestCase
{

    private $data = [];

    public function setUp()
    {
        for ($i = 0; $i < 5; $i++) $this->data['key' . $i] = 'value' . $i;
    }

    public function testOffsetSetGet()
    {
        $dto = new DataObject();

        foreach ($this->data as $key => $value) {
            $dto[$key] = $value;

            $this->assertTrue(isset($dto[$key]));
            $this->assertSame($value, $dto[$key]);
        }
    }

    public function testMagicSetGet()
    {
        $dto = new DataObject();

        foreach ($this->data as $key => $value) {
            $dto->$key = $value;

            $this->assertTrue(isset($dto->$key));
            $this->assertSame($value, $dto->$key);
        }
    }

    public function testSetGetData()
    {
        $dto = new DataObject();
        $dto->setData($this->data);

        $this->assertEquals($this->data, $dto->getData());
    }

    public function testUnset()
    {
        $dto         = new DataObject();
        $dto['key1'] = 'value 1';
        $dto->key2   = 'value 2';

        $this->assertTrue(isset($dto['key1']));
        $this->assertTrue(isset($dto->key2));

        unset($dto['key1'], $dto->key2);

        $this->assertFalse(isset($dto['key1']));
        $this->assertFalse(isset($dto->key2));
    }

    public function testIterator()
    {
        $dto = new DataObject();
        $dto->setData($this->data);

        foreach ($dto as $key => $value) {
            $this->assertEquals($this->data[$key], $value);
        }
    }

    public function testValues()
    {
        $dto = new DataObject();
        $dto->setData($this->data);

        $this->assertEquals(array_values($this->data), $dto->values());

        $arrayObject = new \ArrayObject($this->data);
        $dto->setData($arrayObject);

        $this->assertEquals(array_values($this->data), $dto->values());

        $dto2 = new DataObject();
        $dto2->setData($dto);

        $this->assertEquals(array_values($this->data), $dto->values());
    }

    public function testKeys()
    {
        $dto = new DataObject();
        $dto->setData($this->data);

        $this->assertEquals(array_keys($this->data), $dto->keys());
    }

    public function testCount()
    {
        $dto = new DataObject();
        $dto->setData($this->data);

        $this->assertEquals(count($this->data), count($dto));
    }

    public function testSerialization()
    {
        $dto = new DataObject();
        $dto->setData($this->data);

        $s = serialize($dto);
        $o = unserialize($s);

        $this->assertEquals($dto, $o);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetException1()
    {
        $dto   = new DataObject();
        $dto[] = 'value';
    }

}