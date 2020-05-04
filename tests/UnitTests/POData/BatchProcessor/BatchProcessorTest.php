<?php

declare(strict_types=1);

namespace UnitTests\POData\Common;

use Mockery as m;
use POData\BaseService;
use POData\BatchProcessor\BatchProcessor;
use POData\BatchProcessor\ChangeSetParser;
use POData\BatchProcessor\QueryParser;
use POData\OperationContext\ServiceHost;
use POData\UriProcessor\RequestDescription;
use POData\Writers\Json\IndentedTextWriter;
use UnitTests\POData\BatchProcessor\BatchProcessorDummy;
use UnitTests\POData\TestCase;

class BatchProcessorTest extends TestCase
{
    function tearDown()
    {
        parent::tearDown();
        IndentedTextWriter::$PHP_EOL = "\n";
    }

    public function testBatchRequestPartitioning()
    {
        // take the sample batch request in paragraph 2.2 of the OData v3 batch processing docs, feed it into
        // batchProcessor and verify it chops it into the expected number of things

        $rawData = '
--batch_36522ad7-fc75-4b56-8c71-56071383e77b
Content-Type: application/http 
Content-Transfer-Encoding:binary

GET /service/Customers(\'ALFKI\') 
Host: host

--batch_36522ad7-fc75-4b56-8c71-56071383e77b 
Content-Type: multipart/mixed; boundary=changeset_77162fcd-b8da-41ac-a9f8-9357efbbd621 
Content-Length: ###       

--changeset_77162fcd-b8da-41ac-a9f8-9357efbbd621 
Content-Type: application/http 
Content-Transfer-Encoding: binary 

POST /service/Customers HTTP/1.1 
Host: host  
Content-Type: application/atom+xml;type=entry 
Content-Length: ### 

<AtomPub representation of a new Customer> 

--changeset_77162fcd-b8da-41ac-a9f8-9357efbbd621 
Content-Type: application/http 
Content-Transfer-Encoding:binary 

PUT /service/Customers(\'ALFKI\') HTTP/1.1 
Host: host 
Content-Type: application/json 
If-Match: xxxxx 
Content-Length: ### 

<JSON representation of Customer ALFKI> 

--changeset_77162fcd-b8da-41ac-a9f8-9357efbbd621-- 

--batch_36522ad7-fc75-4b56-8c71-56071383e77b 
Content-Type: application/http 
Content-Transfer-Encoding:binary 

GET service/Products HTTP/1.1 
Host: host 

--batch_36522ad7-fc75-4b56-8c71-56071383e77b--';

        $contentLine    = 'multipart/mixed; boundary=batch_36522ad7-fc75-4b56-8c71-56071383e77b';
        $firstChangeset = m::mock(ChangeSetParser::class);
        $firstChangeset->shouldReceive('handleData')->andReturnNull()->once();
        $firstChangeset->shouldReceive('process')->andReturnNull()->once();
        $firstQuery = m::mock(QueryParser::class);
        $firstQuery->shouldReceive('handleData')->andReturnNull()->once();
        $firstQuery->shouldReceive('process')->andReturnNull()->once();
        $secondQuery = m::mock(QueryParser::class);
        $secondQuery->shouldReceive('handleData')->andReturnNull()->once();
        $secondQuery->shouldReceive('process')->andReturnNull()->once();

        $host = m::mock(ServiceHost::class);
        $host->shouldReceive('getRequestContentType')->andReturn($contentLine)->atLeast(1);
        $service = m::mock(BaseService::class);
        $service->shouldReceive('getHost')->andReturn($host)->once();
        $request = m::mock(RequestDescription::class);
        $request->shouldReceive('getData')->andReturn($rawData)->atLeast(1);

        $foo = m::mock(BatchProcessor::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $foo->shouldReceive('getParser')->with($service, m::any(), true)->andReturn($firstChangeset)->once();
        $foo->shouldReceive('getParser')->with($service, m::any(), false)->andReturn($firstQuery, $secondQuery)
            ->twice();
        $foo->shouldReceive('getService')->andReturn($service)->atLeast(1);
        $foo->shouldReceive('getRequest')->andReturn($request)->atLeast(1);

        $foo->handleBatch();
    }

    public function testBatchRequestPartitioningAsArray()
    {
        // take the sample batch request in paragraph 2.2 of the OData v3 batch processing docs, feed it into
        // batchProcessor and verify it chops it into the expected number of things

        $rawData = '
--batch_36522ad7-fc75-4b56-8c71-56071383e77b
Content-Type: application/http 
Content-Transfer-Encoding:binary

GET /service/Customers(\'ALFKI\') 
Host: host

--batch_36522ad7-fc75-4b56-8c71-56071383e77b 
Content-Type: multipart/mixed; boundary=changeset_77162fcd-b8da-41ac-a9f8-9357efbbd621 
Content-Length: ###       

--changeset_77162fcd-b8da-41ac-a9f8-9357efbbd621 
Content-Type: application/http 
Content-Transfer-Encoding: binary 

POST /service/Customers HTTP/1.1 
Host: host  
Content-Type: application/atom+xml;type=entry 
Content-Length: ### 

<AtomPub representation of a new Customer> 

--changeset_77162fcd-b8da-41ac-a9f8-9357efbbd621 
Content-Type: application/http 
Content-Transfer-Encoding:binary 

PUT /service/Customers(\'ALFKI\') HTTP/1.1 
Host: host 
Content-Type: application/json 
If-Match: xxxxx 
Content-Length: ### 

<JSON representation of Customer ALFKI> 

--changeset_77162fcd-b8da-41ac-a9f8-9357efbbd621-- 

--batch_36522ad7-fc75-4b56-8c71-56071383e77b 
Content-Type: application/http 
Content-Transfer-Encoding:binary 

GET service/Products HTTP/1.1 
Host: host 

--batch_36522ad7-fc75-4b56-8c71-56071383e77b--';

        $contentLine    = 'multipart/mixed; boundary=batch_36522ad7-fc75-4b56-8c71-56071383e77b';
        $firstChangeset = m::mock(ChangeSetParser::class);
        $firstChangeset->shouldReceive('handleData')->andReturnNull()->once();
        $firstChangeset->shouldReceive('process')->andReturnNull()->once();
        $firstQuery = m::mock(QueryParser::class);
        $firstQuery->shouldReceive('handleData')->andReturnNull()->once();
        $firstQuery->shouldReceive('process')->andReturnNull()->once();
        $secondQuery = m::mock(QueryParser::class);
        $secondQuery->shouldReceive('handleData')->andReturnNull()->once();
        $secondQuery->shouldReceive('process')->andReturnNull()->once();

        $host = m::mock(ServiceHost::class);
        $host->shouldReceive('getRequestContentType')->andReturn($contentLine)->atLeast(1);
        $service = m::mock(BaseService::class);
        $service->shouldReceive('getHost')->andReturn($host)->once();
        $request = m::mock(RequestDescription::class);
        $request->shouldReceive('getData')->andReturn([$rawData])->atLeast(1);

        $foo = m::mock(BatchProcessor::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $foo->shouldReceive('getParser')->with($service, m::any(), true)->andReturn($firstChangeset)->once();
        $foo->shouldReceive('getParser')->with($service, m::any(), false)->andReturn($firstQuery, $secondQuery)
            ->twice();
        $foo->shouldReceive('getService')->andReturn($service)->atLeast(1);
        $foo->shouldReceive('getRequest')->andReturn($request)->atLeast(1);

        $foo->handleBatch();
    }

    public function testGetters()
    {
        $service = m::mock(BaseService::class);
        $request = m::mock(RequestDescription::class);

        $foo = new BatchProcessor($service, $request);

        $this->assertTrue($foo->getService() instanceof BaseService);
        $this->assertTrue($foo->getRequest() instanceof RequestDescription);
        $this->assertEquals('', $foo->getBoundary());
    }

    public function testGetChangeSetParser()
    {
        $service = m::mock(BaseService::class);
        $request = m::mock(RequestDescription::class);

        $foo = new BatchProcessorDummy($service, $request);

        $result = $foo->getParser($service, 'bork bork bork', true);
        $this->assertTrue($result instanceof ChangeSetParser);
    }

    public function testGetQueryParser()
    {
        $service = m::mock(BaseService::class);
        $request = m::mock(RequestDescription::class);

        $foo = new BatchProcessorDummy($service, $request);

        $result = $foo->getParser($service, 'bork bork bork', false);
        $this->assertTrue($result instanceof QueryParser);
    }

    /**
     * @dataProvider getEOL()
     * @param $eol
     */
    public function testGetResponse($eol)
    {
        IndentedTextWriter::$PHP_EOL = $eol;
        $resp = m::mock(ChangeSetParser::class)->makePartial();
        $resp->shouldReceive('getResponse')->andReturn(IndentedTextWriter::$PHP_EOL . 'response' . IndentedTextWriter::$PHP_EOL);

        $service = m::mock(BaseService::class);
        $request = m::mock(RequestDescription::class);

        $foo = new BatchProcessorDummy($service, $request);
        $foo->setChangeSetProcessors([$resp, $resp]);

        $actual = $foo->getResponse();

        $bitz = explode('response', $actual);
        $this->assertEquals(3, count($bitz));
    }

    function getEOL()
    {
        return [["\n"],["\r\n"]];
    }
}
