<?php

namespace DataObject\Type;

use DataObject\Type;
use Filterus\Filter;

class UrlType extends Type
{
    public function filter($value)
    {
        $value = $this->addScheme($value);

        return Filter::factory('url')->filter($value);
    }

    public function validate($value)
    {
        $value = $this->addScheme($value);

        return Filter::factory('url')->validate($value);
    }

    private function addScheme($value)
    {
        if (is_string($value)) {
            $scheme = parse_url($value, PHP_URL_SCHEME);

            if (empty($scheme)) $value = 'http://' . $value;
        }

        return $value;
    }
} 