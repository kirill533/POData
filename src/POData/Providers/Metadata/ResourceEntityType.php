<?php

declare(strict_types=1);

namespace POData\Providers\Metadata;

use AlgoWeb\ODataMetadata\MetadataV3\edm\TEntityTypeType;
use InvalidArgumentException;
use ReflectionClass;

/**
 * Class ResourceEntityType.
 * @package POData\Providers\Metadata
 */
class ResourceEntityType extends ResourceType
{
    /**
     * Create new instance of ResourceEntityType.
     * @param \ReflectionClass|\POData\Providers\Metadata\Entity\IDynamic  $instanceType Instance type for the entity type
     * @param TEntityTypeType   $entity       Object containing complex type metadata
     * @param IMetadataProvider $meta         Application's metadata provider
     *
     * @throws InvalidArgumentException
     */
    public function __construct($instanceType, TEntityTypeType $entity, IMetadataProvider $meta)
    {
        $resourceTypeKind = ResourceTypeKind::ENTITY();
        $bitz             = explode('.', $entity->getName());
        $name             = array_pop($bitz);
        $namespaceName    = $meta->getContainerNamespace();
        if (0 < count($bitz)) {
            $namespaceName = implode('.', $bitz);
        }
        $rawType       = $entity->getBaseType();
        $metaNamespace = $namespaceName . '.';

        $rawType  = (null !== $rawType) ? str_replace($metaNamespace, '', $rawType) : null;
        $baseType = null === $rawType ? null : $meta->resolveResourceType($rawType);
        assert(isset($rawType) === isset($baseType), 'Base and raw type nullity inconsistent');

        $isAbstract = $entity->getAbstract();
        parent::__construct($instanceType, $resourceTypeKind, $name, $namespaceName, $baseType, $isAbstract);
    }
}
