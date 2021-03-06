<?php

namespace UnitTests\POData\Facets\NorthWind1;

use POData\Configuration\EntitySetRights;
use POData\Configuration\IServiceConfiguration;
use POData\Configuration\ProtocolVersion;
use POData\OperationContext\ServiceHost;
use POData\Providers\Query\IQueryProvider;

class NorthWindServiceV3Base extends \POData\BaseService
{
    public function __construct(ServiceHost $serviceHost)
    {
        $this->setHost($serviceHost);
        parent::__construct(null);
    }

    /**
     * This method is called only once to initialize service-wide policies.
     *
     * @param IServiceConfiguration $config
     */
    public function initialize(IServiceConfiguration $config)
    {
        $config->setEntitySetPageSize('*', 5);
        $config->setEntitySetAccessRule('*', EntitySetRights::ALL());
        $config->setAcceptCountRequests(true);
        //Disable projection request for testing purpose
        $config->setAcceptProjectionRequests(false);
        $config->setMaxDataServiceVersion(ProtocolVersion::V3());
    }

    /**
     * @return \POData\Providers\Metadata\IMetadataProvider
     */
    public function getMetadataProvider()
    {
        return NorthWindMetadata::CreateRefConstraints();
    }

    /**
     * @return \POData\Providers\Query\IQueryProvider
     */
    public function getQueryProvider(): ?IQueryProvider
    {
        return new NorthWindQueryProvider();
    }

    public function getStreamProviderX()
    {
        throw new \Exception('not implemented');
    }
}
