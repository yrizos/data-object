<?php

namespace DataObjectTest\Entity;

use DataObject\Entity;

class User extends Entity
{

    public static function fields()
    {
        return [
            'id'          => ['type' => 'integer'],
            'date_create' => ['type' => 'date', 'default' => new \DateTime()],
            'date_update' => ['type' => 'date'],
            'username'    => ['type' => 'string'],
            'password'    => ['type' => 'string'],
            'email'       => ['type' => 'email'],
        ];
    }

} 