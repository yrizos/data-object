<?php

namespace DataObject;

use DataObject\Type\RawType;

class Entity extends DataObject
{

    private $modified = false;

    /** @var array */
    private $fields = null;

    public static function fields()
    {
        return [];
    }

    public function getFields()
    {
        if (is_null($this->fields())) {

            $fields = self::fields();
            if (!is_array($fields)) $fields = [];

            foreach ($fields as $offset => $value) {
                $offset = trim(strval($offset));
                if (empty($offset)) continue;

                $this->fields[$offset] = [
                    'type'    => isset($value['type']) ? Type::factory($value['type']) : new RawType(),
                    'default' => isset($value['default']) ? $value['default'] : null
                ];
            }
        }

        return $this->fields();
    }

    public function getField($offset)
    {
        $offset = trim(strval($offset));

        return isset($this->fields[$offset]) ? $this->fields[$offset] : null;
    }

    public function getFieldType($offset)
    {
        $field = $this->getField($offset);

        return $field ? $field['type'] : null;
    }

    public function getFieldDefault($offset)
    {
        $field = $this->getField($offset);

        return $field ? $field['default'] : null;
    }

    public function isModified()
    {
        return $this->modified === true;
    }

} 