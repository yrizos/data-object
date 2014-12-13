<?php

namespace DataObject;

abstract class Type implements TypeInterface
{
    abstract function filter($value);

    abstract function validate($value);

    public static function factory($type)
    {
        if (strpos($type, "\\") === false) {
            $type = ucfirst(strtolower(trim(strval($type))));
            if ($type == 'Int') $type = 'Integer';
            if ($type == 'Bool') $type = 'Boolean';

            $type = "DataEntity\\Type\\" . $type;
        }

        return
            class_exists($type)
            && in_array("DataEntity\\TypeInterface", class_implements($type))
                ? new $type
                : new Raw;
    }
} 