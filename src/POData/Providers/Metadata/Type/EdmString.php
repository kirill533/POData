<?php

declare(strict_types=1);

namespace POData\Providers\Metadata\Type;

/**
 * Class EdmString.
 */
class EdmString implements IType
{
    /**
     * Gets the type code
     * Note: implementation of IType::getTypeCode.
     *
     * @return TypeCode
     */
    public function getTypeCode()
    {
        return TypeCode::STRING();
    }

    /**
     * Checks this type (EdmString) is compatible with another type
     * Note: implementation of IType::isCompatibleWith.
     *
     * @param IType $type Type to check compatibility
     *
     * @return bool
     */
    public function isCompatibleWith(IType $type)
    {
        $code = $type->getTypeCode();

        return TypeCode::STRING() == $code
            || TypeCode::INT32() == $code
            || TypeCode::INT64() == $code
            || TypeCode::INT16() == $code;
    }

    /**
     * Validate a value in Astoria uri is in a format for this type
     * Note: implementation of IType::validate.
     *
     * @param string|mixed $value    The value to validate
     * @param string       $outValue The stripped form of $value that can
     *                               be used in PHP expressions
     *
     * @return bool
     */
    public function validate($value, &$outValue)
    {
        if (!is_string($value)) {
            return false;
        }

        $outValue = $value;

        return true;
    }

    /**
     * Converts the given string value to string type.
     *
     * @param string $stringValue value to convert
     *
     * @return string
     */
    public function convert($stringValue)
    {
        $value = str_replace('%C3%82%C2%BB', '/', $stringValue);
        //Consider the odata url option
        //$filter=ShipName eq 'Antonio%20Moreno%20Taquer%C3%ADa'
        //WebOperationContext will do urldecode, so the clause become
        //$filter=ShipName eq 'Antonio Moreno Taquería', the lexer will
        //give the token as
        //Token {Text string(25):'Antonio Moreno Taquería', Id: EdmString},
        //this function is used to remove the pre-post quotes from Token::Text
        //i.e. 'Antonio Moreno Taquería'
        //to Antonio Moreno Taquería
        $len = strlen($value);
        if (2 > $len) {
            return $value;
        }

        return substr($value, 1, $len - 2);
    }

    /**
     * Convert the given value to a form that can be used in OData uri.
     * Note: The calling function should not pass null value, as this
     * function will not perform any check for nullability.
     *
     * @param mixed $value value to convert
     *
     * @return string
     */
    public function convertToOData($value)
    {
        $rawValue = str_replace('/', '»', $value);

        $detectedEncoding = mb_detect_encoding($rawValue, mb_detect_order(), true);

        $encodedValue = $detectedEncoding ? mb_convert_encoding($rawValue, 'UTF-8', $detectedEncoding) : $rawValue;

        return '\'' . str_replace('%27', "''", urlencode($encodedValue)) . '\'';
    }

    /**
     * Gets full name of the type implementing this interface in EDM namespace
     * Note: implementation of IType::getFullTypeName.
     *
     * @return string
     */
    public function getName()
    {
        return $this->getFullTypeName();
    }

    /**
     * Gets full name of this type in EDM namespace
     * Note: implementation of IType::getFullTypeName.
     *
     * @return string
     */
    public function getFullTypeName()
    {
        return 'Edm.String';
    }
}
