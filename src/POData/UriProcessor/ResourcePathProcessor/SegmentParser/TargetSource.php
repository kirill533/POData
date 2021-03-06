<?php

declare(strict_types=1);

namespace POData\UriProcessor\ResourcePathProcessor\SegmentParser;

use MyCLabs\Enum\Enum;

/**
 * Class TargetSource.
 * @method static PROPERTY()
 * @method static ENTITY_SET()
 * @method static SERVICE_OPERATION()
 * @method static NONE()
 */
class TargetSource extends Enum
{
    /**
     * The source of data has not been determined yet or
     * The source of data is intrinsic to the system i.e Service Document,
     * Metadata or batch requests.
     * The associated TargetKind enum values are:
     *  TargetKind::METADATA
     *  TargetKind::SERVICE_DOCUMENT
     *  TargetKind::BATCH.
     */
    protected const NONE = 1;

    /**
     * An entity set provides the data.
     * The associated TargetKind enum values are:
     *  TargetKind::RESOURCE
     *  TargetKind::LINK.
     */
    protected const ENTITY_SET = 2;

    /**
     * A service operation provides the data.
     * The associated TargetKind enum values are:
     *  TargetKind::VOID_SERVICE_OPERATION.
     */
    protected const SERVICE_OPERATION = 3;

    /**
     * A property of an entity or a complex object provides the data.
     * The associated TargetKind enum values are:
     *  TargetKind::PRIMITIVE
     *  TargetKind::PRIMITIVE_VALUE
     *  TargetKind::COMPLEX_OBJECT
     *  TargetKind::MEDIA_RESOURCE
     *  TargetKind::BAG.
     */
    protected const PROPERTY = 4;
}
