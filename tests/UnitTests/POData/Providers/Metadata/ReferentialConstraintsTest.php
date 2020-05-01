<?php

namespace UnitTests\POData\UriProcessor;

use POData\Common\Url;
use POData\Common\Version;
use UnitTests\POData\Facets\NorthWind1\NorthWindServiceV3Base;
use UnitTests\POData\Facets\ServiceHostTestFake;
use UnitTests\POData\TestCase;

class ReferentialConstraintsTest extends TestCase
{
    /**
     * $filter cannot be applied on bag resource.
     */
    public function testMetadataWithConstraints()
    {
        $baseUri = 'http://localhost:8083/NorthWindDataService.svc/';
        $resourcePath = '$metadata';
        $hostInfo = [
            'AbsoluteRequestUri'    => new Url($baseUri.$resourcePath),
            'AbsoluteServiceUri'    => new Url($baseUri),
            'QueryString'           => '',
            'DataServiceVersion'    => new Version(3, 0),
            'MaxDataServiceVersion' => new Version(3, 0),
        ];

        $host = new ServiceHostTestFake($hostInfo);
        //Note we are using V3 data service
        $dataService = new NorthWindServiceV3Base($host);

        $dataService->handleRequest();

        $res = $dataService->getOperationContext()->outgoingResponse();

        $this->assertXmlStringEqualsXmlFile(__DIR__ . '/metadata-with-constrains.xml', $res->getStream());
    }
}
