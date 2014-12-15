<?php

namespace DataObject;

class Entity extends DataObject implements EntityInterface
{

    private $modified = false;

    /** @var array */
    private $fields = null;

    public static function fields()
    {
        return [];
    }

    /**
     * @return array
     */
    public function getFields()
    {

        if (is_null($this->fields)) {
            $definition = is_array(static::fields()) ? static::fields() : [];

            foreach ($definition as $offset => $value) {
                $offset = trim(strval($offset));
                if (empty($offset)) continue;

                $type    = isset($value['type']) ? $value['type'] : null;
                $default = isset($value['default']) ? $value['default'] : null;

                $this->fields[$offset] = [
                    'type'    => $this->getType($type),
                    'default' => $default
                ];

                parent::offsetSet($offset, null);
            }
        }

        return $this->fields;
    }

    /**
     * @param string $type
     * @return TypeInterface
     */
    protected function getType($type)
    {
        return Type::factory($type);
    }

    /**
     * @param string $offset
     * @return array|null
     */
    public function getField($offset)
    {
        $offset = trim(strval($offset));

        return isset($this->getFields()[$offset]) ? $this->getFields()[$offset] : null;
    }

    /**
     * @param string $offset
     * @return TypeInterface
     */
    public function getFieldType($offset)
    {
        $field = $this->getField($offset);

        return $field ? $field['type'] : $this->getType('raw');
    }

    /**
     * @param string $offset
     * @return mixed
     */
    public function getDefault($offset)
    {
        $field = $this->getField($offset);

        return $field ? $field['default'] : null;
    }

    /**
     * @return bool
     */
    public function isModified()
    {
        return $this->modified === true;
    }

    /**
     * @param string $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        $value = $this->offsetExists($offset) ? parent::offsetGet($offset) : $this->getDefault($offset);
        $type  = $this->getFieldType($offset);

        return $type->filter($value);
    }

    /**
     * @param string $offset
     * @param mixed $value
     * @throws \InvalidArgumentException
     */
    public function offsetSet($offset, $value)
    {
        $type = $this->getFieldType($offset);
        if (
            !$type->validate($value)
            && !($value === $this->getDefault($offset))
        ) throw new \InvalidArgumentException($offset . ' validation failed.');

        if ($value !== parent::offsetGet($offset)) $this->modified = true;

        parent::offsetSet($offset, $value);
    }

    public function getData()
    {
        $offsets = array_keys($this->getRawData());

        foreach ($offsets as $offset) $data[$offset] = $this->offsetGet($offset);

        return $data;
    }

    /**
     * @return array
     */
    public function getRawData()
    {
        $offsets = array_keys($this->getFields());

        foreach ($offsets as $offset) {
            if (!parent::offsetExists($offset)) {
                parent::offsetSet($offset, null);
            }
        }

        return parent::getData();
    }
} 