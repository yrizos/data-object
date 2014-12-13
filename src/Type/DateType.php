<?php

namespace DataObject\Type;

use DataObject\Type;

class DateType extends Type
{
    public function filter($value)
    {
        if (is_int($value) || ctype_digit($value)) {
            $value = '@' . $value;
        }

        if (is_string($value)) {
            try {
                $value = new \DateTime($value);
            } catch (\Exception $e) {
                $value = null;
            }
        }

        return ($value instanceof \DateTime) ? $value : null;
    }

    public function validate($value)
    {
        return
            is_int($value)
            || ctype_digit($value)
            || is_string($value)
            || ($value instanceof \DateTime);
    }
} 