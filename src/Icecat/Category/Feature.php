<?php
namespace Icecat\Category;

use Icecat\Measure as Measure;

/**
 * Class Feature
 *
 * @package Icecat\Category
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Feature
{
    /** @var int */
    protected $categoryFeatureGroupId = 0;

    /** @var int */
    protected $categoryFeatureId = 0;

    /** @var int */
    protected $id = 0;

    protected $langId = 2;

    protected $limitDirection = 0;

    /** @var bool */
    protected $mandatory = false;

    /**
     * Priority indicator
     * The higher the number the more important the feature or feature group is considered to be for buyer orientation
     *
     * @var int
     */
    protected $no = 0;

    /** @var bool */
    protected $searchable = false;

    /** @var string */
    protected $name;

    /**
     * Possible values: "2d", "3d", "dropdown", "multi_dropdown", "numerical", "range", "text", "y_n", ""
     *
     * @var string
     */
    protected $type = '';

    /** @var \Icecat\Measure */
    protected $measure;

    protected $restrictedValues = [];

    /**
     * @param \SimpleXMLElement $feature
     * @param null|int          $langId
     */
    public function __construct(\SimpleXMLElement $feature, $langId = null)
    {
        if (!empty($langId)) {
            $this->langId = $langId;
        }

        $attr = $feature->attributes();
        $this->categoryFeatureGroupId = (int) $attr['CategoryFeatureGroup_ID'];
        $this->categoryFeatureId = (int) $attr['CategoryFeature_ID'];
        $this->id = (int) $attr['ID'];
        $this->limitDirection = (int) $attr['LimitDirection'];
        $this->mandatory = (bool) (string) $attr['Mandatory'];
        $this->no = (int) $attr['No'];
        $this->searchable = (bool) (string) $attr['Searchable'];
        $this->type = (string) $attr['Type'];

        if (count($feature->Measure) > 0) {
            $this->setMeasure(new Measure($feature->Measure, $this->langId));
        }

        if (count($feature->Name) > 0) {
            foreach ($feature->Name as $name) {
                if ($this->langId == $name['langid']) {
                    $this->name = (string) $name;
                    break;
                }
            }
        }

        if (count($feature->RestrictedValue) > 0) {
            foreach ($feature->RestrictedValue as $restrictedValue) {
                $restrictedValue = (string) $restrictedValue;
                if ('' !== $restrictedValue) {
                    $this->restrictedValues[] = $restrictedValue;
                }
            }
        }
    }

    public function setMeasure(Measure $measure)
    {
        $this->measure = $measure;
    }
}
