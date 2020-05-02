<?php

declare(strict_types=1);

namespace UnitTests\POData\ObjectModel\Serialisers;

use Illuminate\Http\Request;
use Mockery as m;
use Symfony\Component\HttpFoundation\HeaderBag;
use UnitTests\POData\TestCase;

class SerialiserTestBase extends TestCase
{
    /**
     * @return m\Mock
     */
    protected function setUpRequest()
    {
        $request = m::mock(Request::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $request->initialize();
        $request->headers = new HeaderBag(['CONTENT_TYPE' => 'application/atom+xml']);
        $request->setMethod('GET');
        $request->shouldReceive('getBaseUrl')->andReturn('http://localhost/');
        $request->shouldReceive('getQueryString')->andReturn('');
        $request->shouldReceive('getHost')->andReturn('localhost');
        $request->shouldReceive('isSecure')->andReturn(false);
        $request->shouldReceive('getPort')->andReturn(80);
        return $request;
    }
}
