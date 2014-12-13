<?php

namespace DataObject\Type;

use DataObject\Type;
use Filterus\Filter;

class BooleanType extends Type
{

    public function filter($value)
    {
        return Filter::factory('bool')->filter($value);
    }

    public function validate($value)
    {
        return !is_null($value) && Filter::factory('bool')->validate($value);
    }

} 