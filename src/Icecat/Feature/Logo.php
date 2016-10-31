<?php
namespace Icecat\Feature;

/**
 * Class Logo
 *
 * The feature logo functionality of Icecat provides you with logos and descriptions that are related
 * to certain highlighted product specifications, such as compliance with EnergyStar, USB3.0, Bluetooth
 * or the presence of Intel Inside technology.
 *
 * Logos can be provided in JPG or PNG image formats and have a maximum resolution of up to 200 x 200 px.
 * Textual descriptions of the feature logo are language specific.
 *
 * @package Icecat\Feature
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Logo
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $featureId;

    /** @var string */
    protected $value = 'Y';

    /** @var string */
    protected $logoPic = '';

    /** @var int */
    protected $height = 0;

    /** @var int */
    protected $width = 0;

    /** @var int */
    protected $size = 0;

    protected $descriptions = [];

    /**
     * @example
     *  <FeatureLogo ID="1" Feature_ID="2183" Value="Y" LogoPic="http://images.icecat.biz/img/feature_logo/1-7814.png" Width="200" Height="200" Size="38243">
     *      <Descriptions>
     *          <Description ID="1" langid="1">
     *              <![CDATA[
     *                  Bluetooth is a proprietary open wireless technology standard for exchanging data over short distances
     *                  (using short-wavelength radio transmissions in the ISM band from 2400–2480 MHz) from fixed and mobile devices,
     *                  creating personal area networks (PANs) with high levels of security.
     *              ]]>
     *          </Description>
     *      </Descriptions>
     *  </FeatureLogo>
     *
     * @param \SimpleXMLElement $logo
     */
    public function __construct(\SimpleXMLElement $logo)
    {
        $attr = $logo->attributes();

        $this->id = (int) $attr['ID'];
        $this->featureId = (int) $attr['Feature_ID'];
        $this->value = (string) $attr['Value'];
        $this->logoPic = (string) $attr['LogoPic'];
        $this->height = (int) $attr['Height'];
        $this->width = (int) $attr['Width'];
        $this->size = (int) $attr['Size'];

        if (!empty($logo->Descriptions->Description)) {
            foreach ($logo->Descriptions->Description as $description) {
                $this->descriptions[] = trim($description);
            }
        }
    }
}
