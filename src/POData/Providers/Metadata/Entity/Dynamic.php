<?php

namespace POData\Providers\Metadata\Entity;

class Dynamic implements IDynamic
{
    private $properties;

    public function __construct($properties)
    {
        $this->properties = $properties;
    }

    function getPropertyNames()
    {
        return array_keys($this->properties);
    }

    function hasProperty($name)
    {
        return isset($this->properties[$name]);
    }

    function getProperties()
    {
        return $this->properties;
    }
}
