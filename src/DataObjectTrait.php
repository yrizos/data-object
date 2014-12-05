<?php

namespace DataObject;

trait DataObjectTrait
{

    private $data = [];

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $data = self::extractArray($data);

        foreach ($data as $key => $value) $this[$key] = $value;

        return $this;
    }

    public function offsetSet($offset, $value)
    {
        if (!is_string($offset)) throw new \InvalidArgumentException('Offset must be string');

        $this->data[$offset] = $value;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    final public function __set($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }

    final public function __get($offset)
    {
        return $this->offsetGet($offset);
    }

    final  public function __isset($offset)
    {
        return $this->offsetExists($offset);
    }

    final public function __unset($offset)
    {
        return $this->offsetUnset($offset);
    }

    final public function values()
    {
        return array_values($this->data);
    }

    final public function keys()
    {
        return array_keys($this->data);
    }

    final public function count()
    {
        return count($this->data);
    }

    final public function serialize()
    {
        return serialize($this->data);
    }

    final public function unserialize($data)
    {
        $this->data = unserialize($data);
    }

    final public function getIterator()
    {
        return new \ArrayIterator($this->getData());
    }

    public static function extractArray($data)
    {
        if ($data instanceof DataObjectInterface) {
            $data = $data->getData();
        } else if ($data instanceof \ArrayObject) {
            $data = $data->getArrayCopy();
        } else if ($data instanceof \Traversable) {
            $temp = [];
            foreach ($data as $key => $value) $temp[$key] = $data;

            $data = $temp;
        }

        if (!is_array($data)) throw new \InvalidArgumentException();

        return $data;
    }
} 