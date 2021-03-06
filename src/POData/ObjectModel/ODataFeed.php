<?php

declare(strict_types=1);

namespace POData\ObjectModel;

/**
 * Class ODataFeed.
 */
class ODataFeed implements EntryProviderInterface
{
    /**
     * Feed iD.
     *
     * @var string
     */
    public $id;
    /**
     * Feed title.
     *
     * @var ODataTitle
     */
    public $title;
    /**
     * Feed self link.
     *
     * @var ODataLink
     */
    public $selfLink;
    /**
     * Row count, in case of $inlinecount option.
     *
     * @var int
     */
    public $rowCount = null;
    /**
     * Enter URL to next page, if pagination is enabled.
     *
     * @var ODataLink
     */
    public $nextPageLink = null;
    /**
     * Collection of entries under this feed.
     *
     * @var ODataEntry[]
     */
    public $entries = [];

    /**
     * @var EntryProviderInterface
     */
    protected $entryProvider;

    /**
     * Last updated timestamp.
     *
     * @var string
     */
    public $updated;

    /**
     * Service Base URI.
     *
     * @var string
     */
    public $baseURI;

    /**
     * @return ODataLink
     */
    public function getNextPageLink()
    {
        return $this->nextPageLink;
    }

    /**
     * @param ODataLink $nextPageLink
     */
    public function setNextPageLink(ODataLink $nextPageLink)
    {
        foreach (get_object_vars($nextPageLink) as $property) {
            if (null !== $property) {
                $this->nextPageLink = $nextPageLink;
                return;
            }
        }
    }

    /**
     * The method is not efficient if a lot of entries will need to be read
     * @return ODataEntry[]
     */
    public function getEntries()
    {
        if (empty($this->entries)) {
            $this->entries = [];

            while ($entry = $this->getNextEntry()) {
                $this->entries[] = $entry;
            }

            $this->clearEntityProvider();
        }

        return $this->entries;
    }

    /**
     * @param ODataEntry[] $entries
     */
    public function setEntries(array $entries)
    {
        $this->clearEntityProvider();
        $this->entries = $entries;
    }

    public function hasEntryProvider()
    {
        return $this->entryProvider !== null;
    }

    public function getNextEntry()
    {
        if (isset($this->entryProvider)) {
            return $this->entryProvider->getNextEntry();
        }
        return null;
    }

    public function setEntryProvider(EntryProviderInterface $provider)
    {
        $this->entryProvider = $provider;
    }

    /**
     * Method might be used for testing.
     */
    public function clearEntityProvider()
    {
        $this->entryProvider = null;
    }
}
