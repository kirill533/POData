<?php

declare(strict_types=1);

namespace UnitTests\POData\Common;

use Exception;
use Mockery as m;
use POData\Common\ErrorHandler;
use POData\Common\HttpStatus;
use POData\Common\MimeTypes;
use POData\Common\ODataConstants;
use POData\Common\ODataException;
use POData\Configuration\ServiceConfiguration;
use POData\IService;
use POData\OperationContext\IOperationContext;
use POData\OperationContext\ServiceHost;
use POData\OperationContext\Web\OutgoingResponse;
use POData\Writers\Json\IndentedTextWriter;
use UnitTests\POData\TestCase;

/**
 * Class ErrorHandlerTest.
 * @package UnitTests\POData\Common
 */
class ErrorHandlerTest extends TestCase
{
    public function testHandleODataException()
    {
        $exception = new ODataException('FAIL', 500);

        $outgoing = m::mock(OutgoingResponse::class);
        $outgoing->shouldReceive('setServiceVersion')
            ->withArgs([ODataConstants::DATASERVICEVERSION_1_DOT_0 . ';'])->andReturnNull()->once();
        $outgoing->shouldReceive('setStatusCode')->withArgs(['500 Internal Server Error'])->andReturnNull()->once();
        $outgoing->shouldReceive('setContentType')->withArgs(['application/xml'])->andReturnNull()->once();
        $outgoing->shouldReceive('setStream')->passthru();
        $outgoing->shouldReceive('getStream')->passthru();

        $context = m::mock(IOperationContext::class);
        $context->shouldReceive('outgoingResponse')->andReturn($outgoing);

        $host = m::mock(ServiceHost::class)->makePartial();
        $host->shouldReceive('getRequestAccept')->andReturn(MimeTypes::MIME_APPLICATION_HTTP);
        $host->shouldReceive('getOperationContext')->andReturn($context);

        $service = m::mock(IService::class);
        $service->shouldReceive('getHost')->andReturn($host);
        $service->shouldReceive('getConfiguration')->andReturn(new ServiceConfiguration(null));


        ErrorHandler::handleException($exception, $service);

        $expected = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<error xmlns="http://schemas.microsoft.com/ado/2007/08/dataservices/metadata">
 <code>500</code>
 <message>FAIL</message>
</error>
';
        $actual = $outgoing->getStream();
        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }

    public function testHandleODataExceptionJson()
    {
        $exception = new ODataException('FAIL', 500);

        $outgoing = m::mock(OutgoingResponse::class);
        $outgoing->shouldReceive('setServiceVersion')
            ->withArgs([ODataConstants::DATASERVICEVERSION_1_DOT_0 . ';'])->andReturnNull()->once();
        $outgoing->shouldReceive('setStatusCode')->withArgs(['500 Internal Server Error'])->andReturnNull()->once();
        $outgoing->shouldReceive('setContentType')->withArgs(['application/json'])->andReturnNull()->once();
        $outgoing->shouldReceive('setStream')->passthru();
        $outgoing->shouldReceive('getStream')->passthru();

        $context = m::mock(IOperationContext::class);
        $context->shouldReceive('outgoingResponse')->andReturn($outgoing);

        $host = m::mock(ServiceHost::class)->makePartial();
        $host->shouldReceive('getRequestAccept')->andReturn(MimeTypes::MIME_APPLICATION_JSON);
        $host->shouldReceive('getOperationContext')->andReturn($context);

        $service = m::mock(IService::class);
        $service->shouldReceive('getHost')->andReturn($host);
        $config = new ServiceConfiguration(null);
        $config->setLineEndings("\n");
        $config->setPrettyOutput(true);
        $service->shouldReceive('getConfiguration')->andReturn($config);


        ErrorHandler::handleException($exception, $service);

        $expected = '{
    "error":{
        "code":"500","message":{
            "lang":"en-US","value":"FAIL"
        }
    }
}';
        $actual   = $outgoing->getStream();
        $expected = preg_replace('~(*BSR_ANYCRLF)\R~', "\r\n", $expected);
        $actual   = preg_replace('~(*BSR_ANYCRLF)\R~', "\r\n", $actual);
        $this->assertEquals($expected, $actual);
    }

    public function testHandleODataExceptionStatusCodeNotModified()
    {
        $exception = new ODataException('FAIL', HttpStatus::CODE_NOT_MODIFIED);

        $outgoing = m::mock(OutgoingResponse::class);
        $outgoing->shouldReceive('setServiceVersion')
            ->withArgs([ODataConstants::DATASERVICEVERSION_1_DOT_0 . ';'])->andReturnNull()->once();
        $outgoing->shouldReceive('setStatusCode')->withArgs(['304 Not Modified'])->andReturnNull()->never();
        $outgoing->shouldReceive('setContentType')->withArgs(['application/json'])->andReturnNull()->never();
        $outgoing->shouldReceive('setStream')->passthru();
        $outgoing->shouldReceive('getStream')->passthru();

        $context = m::mock(IOperationContext::class);
        $context->shouldReceive('outgoingResponse')->andReturn($outgoing);

        $host = m::mock(ServiceHost::class)->makePartial();
        $host->shouldReceive('getRequestAccept')->andReturn(MimeTypes::MIME_APPLICATION_JSON);
        $host->shouldReceive('getOperationContext')->andReturn($context);
        $host->shouldReceive('setResponseStatusCode')
            ->withArgs([HttpStatus::CODE_NOT_MODIFIED])->andReturnNull()->once();

        $service = m::mock(IService::class);
        $service->shouldReceive('getHost')->andReturn($host);
        $service->shouldReceive('getConfiguration')->andReturn(new ServiceConfiguration(null));


        ErrorHandler::handleException($exception, $service);
    }

    /**
     * @dataProvider getEOL()
     * @throws ODataException
     * @param $eol
     */
    public function testHandleExceptionBadMimeTypes($eol)
    {
        $exception = new ODataException('FAIL', 500);

        $outgoing = m::mock(OutgoingResponse::class);
        $outgoing->shouldReceive('setServiceVersion')
            ->withArgs([ODataConstants::DATASERVICEVERSION_1_DOT_0 . ';'])->andReturnNull()->once();
        $outgoing->shouldReceive('setStatusCode')->withArgs(['400 Bad Request'])->andReturnNull()->once();
        $outgoing->shouldReceive('setContentType')->withArgs(['application/xml'])->andReturnNull()->once();
        $outgoing->shouldReceive('setStream')->passthru();
        $outgoing->shouldReceive('getStream')->passthru();

        $context = m::mock(IOperationContext::class);
        $context->shouldReceive('outgoingResponse')->andReturn($outgoing);

        $host = m::mock(ServiceHost::class)->makePartial();
        $host->shouldReceive('getRequestAccept')->andReturn('completely mangled result');
        $host->shouldReceive('getOperationContext')->andReturn($context);

        $service = m::mock(IService::class);
        $service->shouldReceive('getHost')->andReturn($host);
        $config = new ServiceConfiguration(null);
        $config->setLineEndings($eol);
        $service->shouldReceive('getConfiguration')->andReturn($config);


        ErrorHandler::handleException($exception, $service);

        $expected = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . $eol;
        $expected .= '<error xmlns="http://schemas.microsoft.com/ado/2007/08/dataservices/metadata">' . $eol;
        $expected .= ' <code>400</code>' . $eol;
        $expected .= ' <message>Media type requires a \'/\' character.</message>' . $eol;
        $expected .= '</error>' . $eol;
        $actual = $service->getHost()->getOperationContext()->outgoingResponse()->getStream();
        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }

    /**
     * @dataProvider getEOL()
     * @throws ODataException
     * @param $eol
     */
    public function testHandleNonODataExceptionWithValidMimeType($eol)
    {
        $exception = new Exception('FAIL', 500);

        $outgoing = m::mock(OutgoingResponse::class);
        $outgoing->shouldReceive('setServiceVersion')
            ->withArgs([ODataConstants::DATASERVICEVERSION_1_DOT_0 . ';'])->andReturnNull()->once();
        $outgoing->shouldReceive('setStatusCode')->withArgs(['500 Internal Server Error'])->andReturnNull()->once();
        $outgoing->shouldReceive('setContentType')->withArgs(['application/xml'])->andReturnNull()->once();
        $outgoing->shouldReceive('setStream')->passthru();
        $outgoing->shouldReceive('getStream')->passthru();

        $context = m::mock(IOperationContext::class);
        $context->shouldReceive('outgoingResponse')->andReturn($outgoing);

        $host = m::mock(ServiceHost::class)->makePartial();
        $host->shouldReceive('getRequestAccept')->andReturn('application/xml');
        $host->shouldReceive('getOperationContext')->andReturn($context);

        $service = m::mock(IService::class);
        $service->shouldReceive('getHost')->andReturn($host);
        $config = new ServiceConfiguration(null);
        $config->setLineEndings($eol);
        $service->shouldReceive('getConfiguration')->andReturn($config);

        ErrorHandler::handleException($exception, $service);

        $expected = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . $eol;
        $expected .= '<error xmlns="http://schemas.microsoft.com/ado/2007/08/dataservices/metadata">' . $eol;
        $expected .= ' <code>500</code>' . $eol;
        $expected .= ' <message>FAIL</message>' . $eol;
        $expected .= '</error>' . $eol;
        $actual = $service->getHost()->getOperationContext()->outgoingResponse()->getStream();
        $this->assertXmlStringEqualsXmlString($expected, $actual);
    }
}
