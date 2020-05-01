<?php

namespace POData\ObjectModel;

use POData\Providers\Query\QueryResult;

class ODataEntryProvider implements EntryProviderInterface
{
    protected $provider;
    protected $serializer;
    /**
     * EntryProvider constructor.
     * @param EntryProviderInterface $provider
     */
    function __construct(EntryProviderInterface $provider, $serializer)
    {
        $this->setEntryProvider($provider);
        $this->serializer = $serializer;
    }

    function setEntryProvider($provider)
    {
        $this->provider = $provider;
    }
    
    function getNextEntry()
    {
        $entry = $this->provider->getNextEntry();

        if (!$entry instanceof QueryResult) {
            $query = new QueryResult();
            $query->results = $entry;
        } else {
            $query = $entry;
        }
        
        return $this->serializer->writeTopLevelElement($query);
    }
}