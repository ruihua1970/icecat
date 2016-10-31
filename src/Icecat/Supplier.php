<?php
namespace Icecat;

/**
 * Class Supplier
 *
 * @package Icecat
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Supplier
{
    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var bool */
    protected $sponsor = false;

    /**
     * @param \SimpleXMLElement $supplier
     */
    public function __construct(\SimpleXMLElement $supplier)
    {
        $attr = $supplier->attributes();
        $this->id = (int) $attr['ID'];
        $this->name = (string) $attr['Name'];
        if ($attr['Sponsor'] == 1) {
            $this->sponsor = true;
        }
    }

    public function toArray()
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'sponsor' => $this->sponsor,
        ];
    }
}
