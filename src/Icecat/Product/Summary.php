<?php
namespace Icecat\Product;

/**
 * Class Summary
 *
 * @package Icecat\Product
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Summary
{
    /**
     * ShortSummaryDescription has: product name, product family and 1st 6 feature values.
     *
     * @var string
     */
    protected $shortSummary = '';

    /**
     * LongSummaryDescription has product name, product family and the list of feature group name with the feature values.
     *
     * @var string
     */
    protected $longSummary = '';

    /**
     * @param \SimpleXMLElement $summary
     */
    public function __construct(\SimpleXMLElement $summary)
    {
        $this->shortSummary = (string) $summary->ShortSummaryDescription;
        $this->longSummary = (string) $summary->LongSummaryDescription;
    }
}
