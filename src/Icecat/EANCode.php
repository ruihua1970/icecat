<?php
namespace Icecat;

/**
 * Class EANCode
 *
 * @package Icecat
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class EANCode
{
    /** @var string */
    protected $eanCode;

    public function __construct(\SimpleXMLElement $eanCode)
    {
        $attr = $eanCode->attributes();
        $this->eanCode = (string) $attr['EAN'];
    }

    public function __toString()
    {
        return $this->eanCode;
    }
}
