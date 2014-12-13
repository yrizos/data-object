<?php

namespace DataObject;

interface EntityInterface extends DataObjectInterface
{

    public function __construct($data = []);

    public function getFields();

    public function getField($offset);

    public function getFieldType($offset);

    public function getDefault($offset);

    public function isModified();

    public static function fields();
} 