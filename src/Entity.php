<?php

namespace DataObject;

use DataObject\Type\RawType;

class Entity extends DataObject implements EntityInterface
{

    private $modified = false;

    /** @var array */
    private $fields = null;

    public function __construct($data = [])
    {
        $this->getFields();
        $this->setData($data);
    }

    public static function fields()
    {
        return [];
    }

    public function getFields()
    {

        if (is_null($this->fields)) {
            $definition = is_array(static::fields()) ? static::fields() : [];

            foreach ($definition as $offset => $value) {
                $offset = trim(strval($offset));
                if (empty($offset)) continue;

                $this->fields[$offset] = [
                    'type' => isset($value['type']) ? $this->getType($value['type']) : new RawType(),
                    'default' => isset($value['default']) ? $value['default'] : null
                ];

                parent::offsetSet($offset, null);
            }
        }

        return $this->fields;
    }

    protected function getType($type)
    {
        return Type::factory($type);
    }

    public function getField($offset)
    {
        $offset = trim(strval($offset));

        return isset($this->getFields()[$offset]) ? $this->getFields()[$offset] : null;
    }

    /**
     * @param $offset
     * @return TypeInterface
     */
    public function getFieldType($offset)
    {
        $field = $this->getField($offset);

        return $field ? $field['type'] : new RawType();
    }

    public function getDefault($offset)
    {
        $field = $this->getField($offset);

        return $field ? $field['default'] : null;
    }

    public function isModified()
    {
        return $this->modified === true;
    }

    public function offsetGet($offset)
    {
        return
            isset($this->data[$offset])
                ? $this->data[$offset]
                : $this->getDefault($offset);
    }

    public function offsetSet($offset, $value)
    {
        $type = $this->getFieldType($offset);
        if (!$type->validate($value)) throw new \InvalidArgumentException($offset . ' validation failed.');

        $value = $type->filter($value);
        if ($value !== $this->offsetGet($offset)) $this->modified = true;

        parent::offsetSet($offset, $value);
    }

    public function toArray()
    {
        $offsets = $this->keys();
        $array   = [];
        foreach ($offsets as $offset) $array[$offset] = $this->offsetGet($offset);

        return $array;
    }
} 