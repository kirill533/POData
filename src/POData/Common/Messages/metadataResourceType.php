<?php

declare(strict_types=1);

namespace POData\Common\Messages;

/**
 * Trait metadataResourceType.
 * @package POData\Common\Messages
 */
trait metadataResourceType
{
    /**
     * Format a message to show error when entity type of an entity set has a
     * derived type with named stream property(ies).
     *
     * @param string $entitySetName   The entity set name
     * @param string $derivedTypeName The full name of the derived type
     *
     * @return string The formatted message
     */
    public static function metadataResourceTypeSetNamedStreamsOnDerivedEntityTypesNotSupported(
        $entitySetName,
        $derivedTypeName
    ) {
        return 'Named streams are not supported on derived entity types. Entity Set \'' . $entitySetName
            . '\' has an instance of type \'' . $derivedTypeName . '\', which is a derived entity type and has'
            . ' named streams. Please remove all named streams from type \'' . $derivedTypeName . '\'.';
    }

    /**
     * Format a message to show error when complex type having derived type
     * is used as item type of a bag property.
     *
     * @param string $complexTypeName The name of the bag's complex type
     *                                having derived type
     *
     * @return string The formatted message
     */
    public static function metadataResourceTypeSetBagOfComplexTypeWithDerivedTypes($complexTypeName)
    {
        return 'Complex type \'' . $complexTypeName . '\' has derived types and is used as the item type in a bag.'
            . ' Only bags containing complex types without derived types are supported.';
    }
}
