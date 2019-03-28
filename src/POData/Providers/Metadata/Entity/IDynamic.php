<?php

namespace POData\Providers\Metadata\Entity;

interface IDynamic
{
    function getProperties();

    function getPropertyNames();

    function hasProperty($name);
}