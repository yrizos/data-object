<?php

namespace DataObject;

interface Entity extends DataObjectInterface
{

    public static function fields();

    public function getFields();

    public function getField($offset);

    public function getFieldType($offset);

    public function getFieldDefault($offset);

    public function isModified();

} 