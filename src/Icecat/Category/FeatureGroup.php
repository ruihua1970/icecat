<?php
namespace Icecat\Category;

use Icecat\FeatureGroup as IcecatFeatureGroup;

/**
 * Class FeatureGroup
 *
 * @package Icecat\Category
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class FeatureGroup
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $langId = 2;

    /**
     * Priority indicator
     * The higher the number the more important the feature or feature group is considered to be for buyer orientation
     *
     * @var int
     */
    protected $no = 0;

    /** @var IcecatFeatureGroup */
    protected $featureGroup;

    public function __construct(\SimpleXMLElement $categoryFeatureGroup, $langId = null)
    {
        if (!empty($langId)) {
            $this->langId = $langId;
        }

        $attr = $categoryFeatureGroup->attributes();
        $this->id = (int) $attr['ID'];
        $this->no = (int) $attr['No'];

        if (count($categoryFeatureGroup->FeatureGroup) > 0) {
            $this->featureGroup = new IcecatFeatureGroup($categoryFeatureGroup->FeatureGroup, $this->langId);
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
    public function getNo()
    {
        return $this->no;
    }

    public function getName()
    {
        return $this->featureGroup->getName();
    }

    /*public function toArray()
    {
        return [
            'id'           => $this->id,
            'no'           => $this->no,
            'featureGroup' => $this->featureGroup,
        ];
    }*/

    /**
     * @return IcecatFeatureGroup
     */
    public function getFeatureGroup()
    {
        return $this->featureGroup;
    }
}
