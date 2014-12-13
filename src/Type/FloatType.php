<?php

namespace DataObject\Type;

use DataObject\Type;
use Filterus\Filter;

class FloatType extends Type
{

    public function filter($value)
    {
        return Filter::factory('float')->filter($value);
    }

    public function validate($value)
    {
        return Filter::factory('float')->validate($value);
    }

} 