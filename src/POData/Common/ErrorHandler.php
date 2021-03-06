<?php

declare(strict_types=1);

namespace POData\Common;

use Exception;
use POData\HttpProcessUtility;
use POData\IService;
use POData\Writers\Atom\AtomODataWriter;
use POData\Writers\Json\JsonODataV2Writer;

/**
 * Class ErrorHandler.
 */
class ErrorHandler
{
    /**
     * Common function to handle exceptions in the data service.
     *
     * @param  Exception      $exception exception
     * @param  IService       $service   service
     * @throws ODataException
     * @throws Exception
     */
    public static function handleException(Exception $exception, IService $service)
    {
        $acceptTypesText = $service->getHost()->getRequestAccept() ?? '';
        try {
            $responseContentType = HttpProcessUtility::selectMimeType(
                $acceptTypesText,
                [
                    MimeTypes::MIME_APPLICATION_XML,
                    MimeTypes::MIME_APPLICATION_JSON,
                ]
            );
        } catch (HttpHeaderFailure $headerException) {
            $exception = new ODataException(
                $headerException->getMessage(),
                $headerException->getStatusCode()
            );
        } catch (Exception $exception) {
            // Never come here
        }

        if (!isset($responseContentType)) {
            $responseContentType = MimeTypes::MIME_APPLICATION_XML;
        }

        if (!($exception instanceof ODataException)) {
            $exception = new ODataException($exception->getMessage(), HttpStatus::CODE_INTERNAL_SERVER_ERROR);
        }

        $service->getHost()->setResponseVersion(ODataConstants::DATASERVICEVERSION_1_DOT_0 . ';');

        // At this point all kind of exceptions will be converted
        //to 'ODataException'
        if (HttpStatus::CODE_NOT_MODIFIED == $exception->getStatusCode()) {
            $service->getHost()->setResponseStatusCode(HttpStatus::CODE_NOT_MODIFIED);
        } else {
            $service->getHost()->setResponseStatusCode($exception->getStatusCode());
            $service->getHost()->setResponseContentType($responseContentType);
            if (strcasecmp($responseContentType, MimeTypes::MIME_APPLICATION_XML) == 0) {
                $responseBody = AtomODataWriter::serializeException($exception, $service->getConfiguration());
            } else {
                $responseBody = JsonODataV2Writer::serializeException($exception, $service->getConfiguration());
            }

            $service->getHost()->getOperationContext()->outgoingResponse()->setStream($responseBody);
        }
    }
}
