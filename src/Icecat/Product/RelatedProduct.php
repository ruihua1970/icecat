<?php
namespace Icecat\Product;

use Icecat\Product;
use Icecat\Supplier;

/**
 * Class RelatedProduct
 *
 * @package Icecat\Product
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class RelatedProduct
{
    /**
     * If ID = 0, it means, that this relation was generated dynamically, according to RelationsList.xml rules.
     *
     * @var int
     */
    protected $id;

    /** @var int */
    protected $category_id = 0;

    /**
     * the Reverse attribute for product relations is obsolete and can be ignored.
     *
     * @var bool
     */
    protected $reversed = false;

    /** @var bool */
    protected $preferred = false;

    /** @var Product */
    protected $product;

    /**
     * @param \SimpleXMLElement $relatedProduct
     */
    public function __construct(\SimpleXMLElement $relatedProduct)
    {
        $attr = $relatedProduct->attributes();

        $this->id = (int) $attr['ID'];
        $this->category_id = (int) $attr['Category_ID'];
        $this->reversed = (bool) intval($attr['Reversed']);
        $this->preferred = (bool) intval($attr['Preferred']);

        $product = $relatedProduct->Product[0];

        $this->product = new Product();
        $this->product->setDetails($product);
        $this->product->setSupplier($product->Supplier);
    }

    public function toArray()
    {
        return [
            'id'          => $this->id,
            'category_id' => $this->category_id,
            'product'     => $this->product,
        ];
    }
}
