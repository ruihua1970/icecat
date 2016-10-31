<?php
namespace Icecat\Product;

/**
 * Class Family
 *
 * @package Icecat\Product
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Family
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var array */
    protected $series = [];

    /**
     * @param \SimpleXMLElement $family
     */
    public function __construct(\SimpleXMLElement $family)
    {
        $attr = $family->attributes();
        $this->id = (int) $attr['ID'];

        $this->name = (string) $family->Name['Value'];

        foreach ($family->Series as $series) {
            $this->series[] = (string) $series->Name['Value'];
        }
    }
}
