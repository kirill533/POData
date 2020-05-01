<?php

namespace POData\ObjectModel;

class EntryProvider implements EntryProviderInterface
{
    protected $provider;
    /**
     * EntryProvider constructor.
     * @param EntryProviderInterface $provider
     */
    function __construct(EntryProviderInterface $provider)
    {
        $this->setEntryProvider($provider);
    }

    function setEntryProvider($provider)
    {
        $this->provider = $provider;
    }
    
    function getNextEntry()
    {
        return $this->provider->getNextEntry();
    }
}