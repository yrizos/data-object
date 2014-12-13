<?php

namespace DataObject\Type;

use DataObject\Type;

class RawType extends Type
{

    public function filter($value)
    {
        return $value;
    }

    public function validate($value)
    {
        return true;
    }
} 