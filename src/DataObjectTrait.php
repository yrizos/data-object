<?php

namespace DataObject;

trait DataObjectTrait
{

    /** @var array */
    private $data = [];

    /**
     * Get internal data array
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Overwrite internal data array
     *
     * @param array $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = [];
        $data       = self::normalizeArray($data);

        foreach ($data as $offset => $value) $this->offsetSet($offset, $value);

        return $this;
    }

    /**
     * ArrayAccess::offsetSet
     *
     * @param string $offset
     * @param mixed $value
     * @throws \InvalidArgumentException
     */
    public function offsetSet($offset, $value)
    {
        $offset = is_string($offset) ? trim($offset) : null;
        if (empty($offset)) throw new \InvalidArgumentException('Offset must be a non empty string.');

        $this->data[$offset] = $value;
    }

    /**
     * ArrayAccess::offsetExists
     *
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * ArrayAccess::offsetUnset
     *
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    /**
     * ArrayAccess::offsetGet
     *
     * @param string $offset
     * @return mixed null
     */
    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * Magic get
     *
     * @param string $offset
     * @param mixed $value
     */
    final public function __set($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }

    /**
     * Magic set
     *
     * @param string $offset
     * @return mixed
     */
    final public function __get($offset)
    {
        return $this->offsetGet($offset);
    }

    /**
     * Magic isset
     *
     * @param string $offset
     * @return bool
     */
    final public function __isset($offset)
    {
        return $this->offsetExists($offset);
    }

    /**
     * Magic unset
     *
     * @param string $offset
     */
    final public function __unset($offset)
    {
        return $this->offsetUnset($offset);
    }

    /**
     * Countable::count
     *
     * @return int
     */
    public function count()
    {
        return count($this->getData());
    }

    /**
     * Serializable::serialize
     *
     * @return string
     */
    public function serialize()
    {
        return serialize($this->getData());
    }

    /**
     * Serializable::serialize
     *
     * @return data
     */
    public function unserialize($data)
    {
        $data = unserialize($data);

        $this->setData($data);

        return $this->getData();
    }

    /**
     * IteratorAggregate::getIterator
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getData());
    }

    /**
     * Convert to array
     *
     * @param mixed $data
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function normalizeArray($data)
    {
        if ($data instanceof DataObjectInterface) {
            $data = $data->getData();
        } else if ($data instanceof \ArrayObject) {
            $data = $data->getArrayCopy();
        } else if ($data instanceof \Traversable) {
            $data = iterator_to_array($data);
        }

        if (!is_array($data)) throw new \InvalidArgumentException();

        return $data;
    }

} 