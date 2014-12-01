<?php

namespace DTOTest;

use DataObject\DataObject;

class DTOTest extends \PHPUnit_Framework_TestCase
{

    private $data;
    private $dto;

    public function setUp()
    {
        $this->data = [];
        for ($i = 0; $i < 5; $i++) {
            $this->data['key' . $i] = 'value' . $i;
        }

        $this->dto = new DataObject();
        $this->dto->setData($this->data);
    }

    public function testOffsetGet()
    {
        foreach ($this->data as $key => $value) {
            $this->assertEquals($value, $this->dto[$key]);
        }
    }

    public function testMagicSetGet()
    {
        $this->dto->hello = 'world';

        $this->assertEquals('world', $this->dto->hello);
        $this->assertEquals('world', $this->dto['hello']);
    }

    public function testGetData()
    {
        $this->assertEquals($this->data, $this->dto->getData());
    }

    public function testCount()
    {
        $this->assertEquals(count($this->data), count($this->dto));
    }

    public function testSerialize()
    {
        $temp = serialize($this->dto);
        $temp = unserialize($temp);

        $this->assertEquals($this->dto, $temp);
    }

    public function testArrayKeysValues()
    {
        $this->assertEquals(array_keys($this->data), $this->dto->keys());
        $this->assertEquals(array_values($this->data), $this->dto->values());
    }

} 