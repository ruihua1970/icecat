<?php
namespace Icecat\Product;

/**
 * Class Picture
 *
 * @package Icecat\Product
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Picture extends \Icecat\Picture
{
    /** @var array */
    protected $picture = [
        'high'  => [],
        'thumb' => [],
    ];

    public function __construct(\SimpleXMLElement $picture)
    {
        $attr = $picture->attributes();

        if ('' !== trim($attr['HighPic'])) {
            $this->setHighPic($attr['HighPic'], $attr['HighPicSize'], $attr['HighPicWidth'], $attr['HighPicHeight']);
        }

        if ('' !== trim($attr['ThumbPic'])) {
            $this->setThumbPic($attr['ThumbPic'], $attr['ThumbPicSize']);
        }
    }

    public function toArray()
    {
        return $this->picture;
    }
}
