<?php
namespace Icecat\Product;

use Icecat\Feature as IcecatFeature;

/**
 * Class Feature
 *
 * @package Icecat\Product
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

    /** @var int */
    protected $localId = 0;

    /** @var bool */
    protected $localized = false;

    /** @var bool */
    protected $mandatory = false;

    /**
     * Priority indicator
     * The higher the number the more important the feature or feature group is considered to be for buyer orientation
     *
     * @var int
     */
    protected $no = 0;

    /**
     * Presentation_Value is the processed value as can be displayed in a data-sheet.
     * It is based on the international (but localized) feature value with the localized
     * measure unit * and localized decimal separator (comma or dot depending on the country)
     * or - if the international value is absent - on the language-specific value.
     *
     * Also it contains automatically transformed unit (for e.g. “665 mm is being transformed to
     * more friendly “66,5 cm” or “66.5 cm” depending on the country).
     *
     * @var string
     */
    protected $presentationValue = '';

    /** @var bool */
    protected $searchable = false;

    /** @var bool */
    protected $translated = false;

    /** @var string */
    protected $value = '';

    /** @var IcecatFeature */
    protected $feature;

    /**
     * LocalValue is a local transformation of our international Value attribute.
     * It applies the local dictionary to Value and transforms values according to local standards.
     * As in Value attribute LocalValue contains value of the feature and measurement unit as a separate attributes.
     *
     * @var string
     */
    protected $localValue;

    /**
     * @param \SimpleXMLElement $feature
     */
    public function __construct(\SimpleXMLElement $feature)
    {
        $attr = $feature->attributes();
        $this->categoryFeatureGroupId = (int) $attr['CategoryFeatureGroup_ID'];
        $this->categoryFeatureId = (int) $attr['CategoryFeature_ID'];
        $this->id = (int) $attr['ID'];
        $this->no = (int) $attr['No'];
        $this->localId = (int) $attr['Local_ID'];
        $this->localized = (bool) intval($attr['Localized']);
        $this->mandatory = (bool) intval($attr['Mandatory']);
        $this->searchable = (bool) intval($attr['Searchable']);
        $this->translated = (bool) intval($attr['Translated']);
        $this->presentationValue = str_ireplace(
            [ '\n', '<b>', '</b>', PHP_EOL, '  ' ],
            [ '<br />', '<strong>', '</strong>', ' ', ' ' ],
            $attr['Presentation_Value']);
        $this->value = str_ireplace(
            [ '\n', '<b>', '</b>', PHP_EOL, '  ' ],
            [ '<br />', '<strong>', '</strong>', ' ', ' ' ],
            (string) $attr['Value']);

        $this->feature = new IcecatFeature($feature->Feature);
        $this->localValue = (string) $feature->LocalValue['Value'];
    }

    /**
     * @return string
     */
    public function getValue()
    {
        if ($this->translated || $this->localized) {
            return $this->presentationValue;
        }

        return $this->value;
    }

    /**
     * @return int
     */
    public function getCategoryFeatureGroupId()
    {
        return $this->categoryFeatureGroupId;
    }

    /**
     * @return int
     */
    public function getCategoryFeatureId()
    {
        return $this->categoryFeatureId;
    }

    /**
     * @return IcecatFeature
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * @return int
     */
    public function getNo()
    {
        return $this->no;
    }

    /**
     * @return bool
     */
    public function isSearchable()
    {
        return $this->searchable;
    }

    /**
     * @return bool
     */
    public function isMandatory()
    {
        return $this->mandatory;
    }
}
