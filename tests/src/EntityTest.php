<?php

namespace DataObjectTest;

use DataObjectTest\Entity\User;

class EntityTest extends \PHPUnit_Framework_TestCase
{

    public function testFields()
    {
        $entity = new User();
        $fields = $entity->getFields();

        $this->assertArrayHasKey('id', $fields);
        $this->assertArrayHasKey('date_create', $fields);
        $this->assertArrayHasKey('date_update', $fields);
        $this->assertArrayHasKey('username', $fields);
        $this->assertArrayHasKey('password', $fields);
        $this->assertArrayHasKey('email', $fields);
    }

} 