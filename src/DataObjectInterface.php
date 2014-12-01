<?php

namespace DataObject;

interface DataObjectInterface extends \ArrayAccess, \Countable, \Serializable
{

    public function getData();

    public function setData($data);

    public function __set($offset, $value);

    public function __get($offset);

    public function __isset($offset);

    public function __unset($offset);

    public function values();

    public function keys();

}