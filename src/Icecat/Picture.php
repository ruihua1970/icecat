<?php
namespace Icecat;

/**
 * Class Picture
 *
 * @package Icecat
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Picture
{
    /** @var int ProductPicture_ID */
    protected $id;

    /** @var bool */
    protected $logo = false;

    /** @var int */
    protected $no = 0;

    /** @var string */
    protected $original = '';

    // medium and low are missing sometime
    /** @var array */
    protected $picture = [
        'high'   => [],
        'medium' => [],
        'low'    => [],
        'thumb'  => [],
    ];

    public function __construct(\SimpleXMLElement $picture)
    {
        $attr = $picture->attributes();
        $this->id = (int) $attr['ProductPicture_ID'];
        $this->logo = (bool) $attr['logo'];
        $this->setHighPic($attr['Pic'], $attr['Size'], $attr['PicWidth'], $attr['PicHeight']);
        $this->setThumbPic($attr['ThumbPic'], $attr['ThumbSize']);
    }

    /**
     * @param string $src    Pic
     * @param int    $size   Size
     * @param int    $width  PicWidth
     * @param int    $height PicHeight
     */
    public function setHighPic($src, $size = 0, $width = 0, $height = 0)
    {
        $this->setPic('high', $src, $size, $width, $height);
    }

    /**
     * @param string $src    Pic500x500
     * @param int    $size   Pic500x500Size
     * @param int    $width  Pic500x500Width
     * @param int    $height Pic500x500Height
     */
    public function setMediumPic($src, $size = 0, $width = 0, $height = 0)
    {
        $this->setPic('medium', $src, $size, $width, $height);
    }

    /**
     * @param string $src    LowPic
     * @param int    $size   LowSize
     * @param int    $width  LowPicWidth
     * @param int    $height LowPicHeight
     */
    public function setLowPic($src, $size = 0, $width = 0, $height = 0)
    {
        $this->setPic('low', $src, $size, $width, $height);
    }

    /**
     * @param string $src  ThumbPic
     * @param int    $size ThumbSize
     */
    public function setThumbPic($src, $size = 0)
    {
        $this->setPic('thumb', $src, $size, 75, 75);
    }

    /**
     * @param string $type
     * @param string $src
     * @param int    $size
     * @param int    $width
     * @param int    $height
     */
    private function setPic($type, $src, $size, $width, $height)
    {
        if (in_array($type, [ 'high', 'medium', 'low', 'thumb' ])) {
            $this->picture[$type] = [
                'height' => (int) $height,
                'size'   => (int) $size,
                'src'    => (string) $src,
                'width'  => (int) $width,
            ];
        }
    }

    public function toArray()
    {
        return [
            'id'      => $this->id,
            'logo'    => $this->logo,
            'picture' => $this->picture,
        ];
    }
}
