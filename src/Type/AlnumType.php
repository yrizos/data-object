<?php

namespace DataObject\Type;

use DataObject\Type;
use Filterus\Filter;

class AlnumType extends Type
{
    public function filter($value)
    {
        return Filter::factory('alnum,min:1')->filter($value);
    }

    public function validate($value)
    {
        return Filter::factory('alnum,min:1')->validate($value);
    }
} 