<?php
namespace Icecat;

/**
 * Class Review
 *
 * @package Icecat
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Review
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $langId = 2;

    /** @var string Name */
    protected $code = '';

    /** @var string $logo */
    protected $logo = '';

    /** @var int */
    protected $score = 0;

    /** @var string */
    protected $url = '';

    /** @var \DateTime */
    protected $dateAdded = '';

    /** @var \DateTime */
    protected $updated = '';

    /** @var string */
    protected $value = '';

    /** @var string */
    protected $valueGood = '';

    /** @var string */
    protected $valueBad = '';

    /** @var string */
    protected $bottomLine = '';

    public function __construct(\SimpleXMLElement $review)
    {
        $attr = $review->attributes();
        $this->id = (int) $attr['ID'];
        $this->langId = (int) $attr['LangID'];
        $this->code = (string) $attr['Code'];
        $this->logo = (string) $attr['LogoPic'];
        $this->score = (int) $attr['Score'];
        $this->url = (string) $attr['URL'];
        $this->dateAdded = (string) $attr['DateAdded'];
        $this->updated = (string) $attr['Updated'];

        if (count($review->Value) == 1) {
            $this->value = (string) $review->Value;
        }

        if (count($review->ValueGood) == 1) {
            $this->valueGood = (string) $review->ValueGood;
        }

        if (count($review->ValueBad) == 1) {
            $this->valueBad = (string) $review->ValueBad;
        }

        if (count($review->BottomLine) == 1) {
            $this->bottomLine = (string) $review->BottomLine;
        }
    }

    public function getLangId()
    {
        return $this->langId;
    }
}
