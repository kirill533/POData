<?php

namespace POData\ObjectModel;

class ArrayEntryProvider implements EntryProviderInterface
{
    protected $entries;
    /**
     * EntryProvider constructor.
     * @param EntryProviderInterface $provider
     */
    function __construct(array &$entries)
    {
        $this->entries = $entries;
    }

    function getNextEntry()
    {
        return array_shift($this->entries);
    }
}