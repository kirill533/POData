<?php

namespace POData\ObjectModel;

use Illuminate\Support\Collection;

class CollectionEntryProvider implements EntryProviderInterface
{
    protected $entries;
    /**
     * EntryProvider constructor.
     * @param Collection $col
     */
    function __construct(Collection $col)
    {
        $this->entries = $col;
    }

    function getNextEntry()
    {
        return $this->entries->shift();
    }
}