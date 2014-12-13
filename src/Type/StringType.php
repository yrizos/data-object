<?php

namespace DataObject\Type;

use DataObject\Type;
use Filterus\Filter;

class StringType extends Type
{

    public function filter($value)
    {
        return Filter::factory('string,min:1')->filter($value);
    }

    public function validate($value)
    {
        return
            !is_bool($value)
            && Filter::factory('string,min:1')->validate($value);
    }
} 