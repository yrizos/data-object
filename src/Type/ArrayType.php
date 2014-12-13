<?php

namespace DataObject\Type;

use DataObject\Type;
use Filterus\Filter;

class ArrayType extends Type
{

    public function filter($value)
    {
        return Filter::factory('array')->filter($value);
    }

    public function validate($value)
    {
        return Filter::factory('array')->validate($value);
    }
} 