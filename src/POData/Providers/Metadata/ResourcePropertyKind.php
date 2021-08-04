<?php

declare(strict_types=1);

namespace POData\Providers\Metadata;

use Cruxinator\BitMask\BitMask;

/**
 * Class ResourcePropertyKind.
 * @method static KEY()
 * @method static ETAG()
 * @method static COMPLEX_TYPE()
 * @method static BAG()
 * @method static PRIMITIVE()
 * @method static RESOURCE_REFERENCE()
 * @method static RESOURCESET_REFERENCE()
 * @method static NONE()
 */
class ResourcePropertyKind extends BitMask
{
    const NONE = 0;

    /**
     * A bag of primitive or complex types.
     */
    const BAG = 1;

    /**
     * A complex (compound) property.
     */
    const COMPLEX_TYPE = 2;

    const FIX_3 = 3;

    /**
     * Whether this property is a etag property.
     */
    const ETAG = 4;

    const FIX_5 = 5;
    const FIX_6 = 6;
    const FIX_7 = 7;
    /**
     * A property that is part of the key.
     */
    const KEY = 8;

    const FIX_9 = 9;
    const FIX_10 = 10;
    const FIX_11 = 11;
    const FIX_12 = 12;
    const FIX_13 = 13;
    const FIX_14 = 14;
    const FIX_15 = 15;


    /**
     * A primitive type property.
     */
    const PRIMITIVE = 16;

    const FIX_17 = 17;
    const FIX_18 = 18;
    const FIX_19 = 19;
    const FIX_20 = 20;
    const FIX_21 = 21;
    const FIX_22 = 22;
    const FIX_23 = 23;
    const FIX_24 = 24;
    const FIX_25 = 25;
    const FIX_26 = 26;
    const FIX_27 = 27;
    const FIX_28 = 28;
    const FIX_29 = 29;
    const FIX_30 = 30;
    const FIX_31 = 31;

    /**
     * A reference to another resource.
     */
    const RESOURCE_REFERENCE = 32;

    const FIX_33 = 33;
    const FIX_34 = 34;
    const FIX_35 = 35;
    const FIX_36 = 36;
    const FIX_37 = 37;
    const FIX_38 = 38;
    const FIX_39 = 39;
    const FIX_40 = 40;
    const FIX_41 = 41;
    const FIX_42 = 42;
    const FIX_43 = 43;
    const FIX_44 = 44;



    /**
     * A reference to another resource set.
     */
    const RESOURCESET_REFERENCE = 64;
}
