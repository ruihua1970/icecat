<?php
namespace Icecat;

/**
 * Class Feature
 *
 * @package Icecat
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Feature
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $langId = 2;

    /** @var string */
    protected $description = '';

    /** @var string */
    protected $name;

    /**
     * Possible values: "2d", "3d", "dropdown", "multi_dropdown", "numerical", "range", "text", "y_n", ""
     *
     * @var string
     */
    protected $type = '';

    /** @var Measure */
    protected $measure;

    protected $restrictedValues = [];

    public function __construct(\SimpleXMLElement $feature, $langId = null)
    {
        if (!empty($langId)) {
            $this->langId = $langId;
        }

        $attr = $feature->attributes();
        $this->id = (int) $attr['ID'];

        $this->type = (string) $attr['Type'];

        if (count($feature->Measure) > 0) {
            $this->setMeasure(new Measure($feature->Measure, $this->langId));
        }

        if (count($feature->Name) == 1) {
            $this->name = (string) $feature->Name['Value'];
        }

        if (count($feature->Names) == 1 && count($feature->Names->Name) > 0) {
            foreach ($feature->Names->Name as $name) {
                if ($this->langId == $name['langid']) {
                    $this->name = (string) $name;
                    break;
                }
            }
        }

        if (count($feature->Descriptions) == 1 && count($feature->Descriptions->Description) > 0) {
            foreach ($feature->Descriptions->Description as $restrictedValue) {
                if ($this->langId == $restrictedValue['langid']) {
                    $this->description = (string) $restrictedValue;
                    break;
                }
            }
        }

        if (count($feature->RestrictedValues) == 1 && count($feature->RestrictedValues->RestrictedValue) > 0) {
            foreach ($feature->RestrictedValues->RestrictedValue as $restrictedValue) {
                $restrictedValue = (string) $restrictedValue;
                if ('' !== $restrictedValue) {
                    $this->restrictedValues[] = $restrictedValue;
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
     * @return Measure
     */
    public function getMeasure()
    {
        return $this->measure;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setMeasure(Measure $measure)
    {
        $this->measure = $measure;
    }
}
