<?php

namespace DataObject;

interface TypeInterface
{

    public function filter($value);

    public function validate($value);

} 