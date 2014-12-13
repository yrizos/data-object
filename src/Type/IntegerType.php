<?php

namespace DataObject\Type;

use DataObject\Type;
use Filterus\Filter;

class IntegerType extends Type
{

    public function filter($value)
    {
        return Filter::factory('int')->filter($value);
    }

    public function validate($value)
    {
        return
            !is_bool($value)
            && Filter::factory('int')->validate($value);
    }

} 