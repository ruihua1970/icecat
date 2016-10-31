<?php
namespace Icecat;

/**
 * Class Language
 *
 * @package Icecat
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Language
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $langId = 2;

    /** @var string */
    protected $code = '';

    /** @var string */
    protected $name = '';

    protected $countries = [];

    public function __construct(\SimpleXMLElement $language, $langId = null)
    {
        if (!empty($langId)) {
            $this->langId = $langId;
        }

        $attr = $language->attributes();
        $this->id = (int) $attr['ID'];
        $this->code = (string) $attr['ShortCode'];

        if (count($language->Name) > 0) {
            foreach ($language->Name as $name) {
                if ($this->langId == $name['langid']) {
                    $this->name = (string) $name['Value'];
                    break;
                }
            }
        }

        if (count($language->Countries) == 1 && count($language->Countries->Country) > 0) {
            foreach ($language->Countries->Country as $country) {
                $this->countries[(int) $country['ID']] = (string) $country['Code'];
            }
        }
    }
}
