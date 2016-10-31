<?php
namespace Icecat;

/**
 * Class Measure
 *
 * @package Icecat
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Measure
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $langId = 2;

    /** @var string */
    protected $description = '';

    /** @var string */
    protected $name = '';

    protected $sign = '';

    public function __construct(\SimpleXMLElement $measure, $langId = null)
    {
        if (!empty($langId)) {
            $this->langId = $langId;
        }

        $attr = $measure->attributes();
        $this->id = (int) $attr['ID'];
        $this->sign = (string) $attr['Sign'];

        if (count($measure->Sign) == 1) {
            $sign = (string) $measure->Sign;
            if ('' !== $sign) {
                $this->sign = $sign;
            }
        }

        if (count($measure->Signs) == 1 && count($measure->Signs->Sign) > 0) {
            foreach ($measure->Signs->Sign as $name) {
                if ($this->langId == $name['langid']) {
                    $sign = (string) $name;
                    if ('' !== $sign) {
                        $this->sign = $sign;
                    }
                    break;
                }
            }
        }

        if (count($measure->Description) > 0) {
            foreach ($measure->Description as $description) {
                if ($this->langId == $description['langid']) {
                    $this->description = (string) $description;
                    break;
                }
            }
        }

        if (count($measure->Names) == 1 && count($measure->Names->Name) > 0) {
            foreach ($measure->Names->Name as $name) {
                if ($this->langId == $name['langid']) {
                    $this->name = (string) $name;
                    break;
                }
            }
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getLangId()
    {
        return $this->langId;
    }

    /**
     * @return string
     */
    public function getSign()
    {
        return $this->sign;
    }
}
