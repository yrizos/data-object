<?php

namespace DataObject;

interface EntityInterface extends DataObjectInterface
{

    public function getRawData();

    public function getFields();

    public function getField($offset);

    public function getFieldType($offset);

    public function getDefault($offset);

    public function isModified();

    public function keys();

    public static function fields();
} 