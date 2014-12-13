<?php

namespace DataObjectTest;

use DataObjectTest\Entity\User;

class EntityTest extends \PHPUnit_Framework_TestCase
{

    public function testFields()
    {
        $entity = new User();
        $fields = $entity->getFields();

        $this->assertEquals(count(User::fields()), count($fields));

        $this->assertArrayHasKey('id', $fields);
        $this->assertArrayHasKey('date_create', $fields);
        $this->assertArrayHasKey('date_update', $fields);
        $this->assertArrayHasKey('username', $fields);
        $this->assertArrayHasKey('password', $fields);
        $this->assertArrayHasKey('email', $fields);

        $this->assertInstanceOf("DataObject\\TypeInterface", $entity->getFieldType('id'));
        $this->assertInstanceOf("DataObject\\TypeInterface", $entity->getFieldType('date_create'));
        $this->assertInstanceOf("DataObject\\TypeInterface", $entity->getFieldType('date_update'));
        $this->assertInstanceOf("DataObject\\TypeInterface", $entity->getFieldType('username'));
        $this->assertInstanceOf("DataObject\\TypeInterface", $entity->getFieldType('password'));
        $this->assertInstanceOf("DataObject\\TypeInterface", $entity->getFieldType('email'));

        $this->assertInstanceOf("DateTime", $entity->getDefault('date_create'));
    }

    public function testDefault()
    {
        $entity = new User();

        $this->assertInstanceOf('DateTime', $entity->getDefault('date_create'));
        $this->assertInstanceOf('DateTime', $entity['date_create']);
        $this->assertEquals($entity->getDefault('date_create'), $entity['date_create']);
    }

    public function testModified()
    {
        $entity = new User();

        $this->assertFalse($entity->isModified());

        $entity->username = 'username';

        $this->assertTrue($entity->isModified());
    }

    public function testToArray()
    {
        $entity = new User();
        $data   = $entity->getData();
        $array  = $entity->toArray();

        $this->assertNull($data['date_create']);
        $this->assertInstanceOf('DateTime', $array['date_create']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidation()
    {
        $entity        = new User();
        $entity->email = 'Hello World';
    }
} 