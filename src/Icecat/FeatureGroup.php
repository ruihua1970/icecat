<?php
namespace Icecat;

/**
 * Class FeatureGroup
 *
 * @package Icecat
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class FeatureGroup
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $langId = 2;

    /** @var string */
    protected $name;

    /**
     * @param \SimpleXMLElement $featureGroup
     * @param null|int          $langId
     */
    public function __construct(\SimpleXMLElement $featureGroup, $langId = null)
    {
        if (!empty($langId)) {
            $this->langId = $langId;
        }

        $attr = $featureGroup->attributes();
        $this->id = (int) $attr['ID'];

        if (count($featureGroup->Name) > 0) {
            if (count($featureGroup->Name) == 1) {
                $this->name = (string) $featureGroup->Name['Value'];
            } else {
                foreach ($featureGroup->Name as $name) {
                    if ($this->langId == $name['langid']) {
                        $this->name = (string) $name['Value'];
                        break;
                    }
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
    public function getName()
    {
        return $this->name;
    }
}
