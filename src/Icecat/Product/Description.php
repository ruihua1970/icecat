<?php
namespace Icecat\Product;

/**
 * Class Description
 *
 * @package Icecat\Product
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Description
{
    protected $description = [];

    /**
     * @param \SimpleXMLElement $description
     */
    public function __construct(\SimpleXMLElement $description)
    {
        $this->description = [
            'langid'       => (int) $description['langid'],
            'longDesc'     => str_ireplace(
                [ '\n', '<b>', '</b>', PHP_EOL, '  ' ],
                [ '<br />', '<strong>', '</strong>', ' ', ' ' ],
                (string) $description['LongDesc']),
            'shortDesc'    => (string) $description['ShortDesc'],
            'warrantyInfo' => (string) $description['WarrantyInfo'],
            //            'manualPdfUrl'  => '',
            //            'manualPdfSize' => '',
            //            'pdfUrl'        => '',
            //            'pdfSize'       => '',
            //            'url'           => '',
        ];
    }

    public function toArray()
    {
        return $this->description;
    }
}
