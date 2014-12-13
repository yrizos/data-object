<?php

namespace DataObject\Type;

use DataObject\Type;
use Filterus\Filter;

class IpType extends Type
{
    public function filter($value)
    {
        return Filter::factory('ip')->filter($value);
    }

    public function validate($value)
    {
        return Filter::factory('ip')->validate($value);
    }
} 