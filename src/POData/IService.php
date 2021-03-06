<?php

declare(strict_types=1);

namespace POData;

use POData\Configuration\IServiceConfiguration;
use POData\OperationContext\IOperationContext;
use POData\OperationContext\ServiceHost;
use POData\Providers\Metadata\IMetadataProvider;
use POData\Providers\ProvidersWrapper;
use POData\Providers\Stream\IStreamProvider2;
use POData\Providers\Stream\StreamProviderWrapper;
use POData\Readers\ODataReaderRegistry;
use POData\Writers\ODataWriterRegistry;

/**
 * Interface IService.
 * @package POData
 */
interface IService
{
    /**
     * This method is called only once to initialize service-wide policies.
     *
     * @param  IServiceConfiguration $config data service configuration
     * @return void
     */
    public function initialize(IServiceConfiguration $config);

    /**
     * Gets reference to the configuration class to access the
     * configuration set by the developer.
     *
     * @return IServiceConfiguration
     */
    public function getConfiguration();

    /**
     * Gets reference to wrapper class instance over IDSQP and IDSMP
     * implementation.
     *
     * @return ProvidersWrapper
     */
    public function getProvidersWrapper();

    /**
     * Gets reference to wrapper class instance over IDSSP implementation.
     *
     * @return StreamProviderWrapper
     */
    public function getStreamProviderWrapper();

    /**
     * @return IStreamProvider2
     */
    public function getStreamProviderX();

    /**
     * To set reference to the ServiceHost instance created by the dispatcher.
     *
     * @param  ServiceHost $serviceHost data service host
     * @return void
     */
    public function setHost(ServiceHost $serviceHost);

    /**
     * Hold reference to the ServiceHost instance created by dispatcher,
     * using this library can access headers and body of Http Request
     * dispatcher received and the Http Response Dispatcher is going to send.
     *
     * @return ServiceHost
     */
    public function getHost();

    /**
     * To get reference to operation context where we have direct access to
     * headers and body of Http Request we have received and the Http Response
     * We are going to send.
     *
     * @return IOperationContext
     */
    public function getOperationContext();

    /**
     * Returns the ODataWriterRegistry to use when writing the response to a service document or resource request.
     *
     * @return ODataWriterRegistry
     */
    public function getODataWriterRegistry();

    /**
     * Returns the ODataWriterRegistry to use when writing the response to a service document or resource request.
     *
     * @return ODataReaderRegistry
     */
    public function getODataReaderRegistry();

    /**
     * Returns the service's metadata provider.
     *
     * @return IMetadataProvider
     */
    public function getMetadataProvider();
}
