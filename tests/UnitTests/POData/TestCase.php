<?php

declare(strict_types=1);

namespace UnitTests\POData;

use Carbon\Carbon;
use POData\ObjectModel\ModelDeserialiser;
use POData\Providers\Metadata\SimpleMetadataProvider;
use POData\Providers\Metadata\Type\DateTime;

/**
 * Class TestCase.
 * @package UnitTests\POData
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    public function setUp()
    {
        // clean up static caches, lookups, etc, to break coupling between tests
        $decereal = new ModelDeserialiser();
        $decereal->reset();
        $bar = new SimpleMetadataProvider('Data', 'Data');
        unset($bar);
        DateTime::setTimeProvider([new Carbon(), 'now']);
    }

    public function tearDown()
    {
        \Mockery::close();
        DateTime::setTimeProvider(null);
    }

    /**
     * Get List of End Of Line combinations, supported
     * @return array
     */
    function getEOL()
    {
        return [["\n"],["\r\n"]];
    }
}
