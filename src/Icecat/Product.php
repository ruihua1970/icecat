<?php
namespace Icecat;

use Icecat\Category\FeatureGroup;
use Icecat\Feature\Logo;
use Icecat\Product\Description;
use Icecat\Product\Family;
use Icecat\Product\Feature;
use Icecat\Product\Picture as ProductPicture;
use Icecat\Product\RelatedProduct;
use Icecat\Product\Summary;

/**
 * Class Product
 *
 * @package Icecat
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Product
{
    /** @var int */
    public $id;

    /** @var int */
    protected $code = 1; // seems it's always 1

    /** @var string */
    protected $prod_id = '';

    /** @var string */
    protected $quality = 'ICECAT';

    /** @var string */
    protected $name = '';

    /** @var string */
    protected $title = '';

    /** @var Category */
    protected $category;

    /** @var FeatureGroup[] */
    protected $categoryFeatureGroup = [];

    /** @var Description */
    protected $description;

    /** @var array */
    protected $eanCode = [];

    /** @var Family */
    protected $family;

    /** @var array */
    protected $featureLogo = [];

    /** @var Feature[] */
    protected $features = [];

    /** @var ProductPicture */
    protected $picture;

    /** @var array */
    protected $gallery = [];

    /** @var RelatedProduct[] */
    protected $relatedProducts = [];

    /** @var Summary */
    protected $summary;

    /** @var Supplier */
    protected $supplier;

    public function getSpecifications()
    {
        $specs = [];
        /** @var Feature $feature */
        foreach ($this->features as $feature) {
            /** @var FeatureGroup $group */
            foreach ($this->categoryFeatureGroup as $group) {
                if ($feature->getCategoryFeatureGroupId() == $group->getId()) {
                    $specs[$group->getNo()][$group->getName()][$feature->getFeature()->getName()] = $feature->getValue();
                    break;
                }
            }
        }

        krsort($specs);

        return $specs;
    }

    public function setProductFromXml(\SimpleXMLElement $xml)
    {
        $this->setDetails($xml->Product);
        $this->setBundled($xml->Product->ProductBundled);
        $this->setCategory($xml->Product->Category);
        $this->setCategoryFeatureGroups($xml->xpath('//CategoryFeatureGroup'));
        $this->setDescription($xml->Product->ProductDescription);
        $this->setEanCodes($xml->xpath('//EANCode'));
        $this->setFamily($xml->Product->ProductFamily);
        $this->setFeatureLogos($xml->xpath('//FeatureLogo'));
        $this->setFeatures($xml->xpath('//ProductFeature'));
        $this->setGallery($xml->Product->ProductGallery->ProductPicture);
        $this->setRelatedProducts($xml->Product->ProductRelated);
        $this->setSummary($xml->Product->SummaryDescription);
        $this->setSupplier($xml->Product->Supplier);
    }

    public function setSupplier($supplier)
    {
        if (!empty($supplier) && $supplier instanceof \SimpleXMLElement) {
            $this->supplier = new Supplier($supplier);
        }
    }

    public function toArray()
    {
        return [
            'id'                   => $this->id,
            'code'                 => $this->code,
            'prod_id'              => $this->prod_id,
            'name'                 => $this->name,
            'title'                => $this->title,
            'ean'                  => $this->eanCode,
            // for relatedProducts, category is not defined at Product level, but as category_id at relatedProduct level
            'category'             => (!empty($this->category) ? $this->category->toArray() : null),
            'description'          => $this->description,
            'supplier'             => $this->supplier->toArray(),
            'gallery'              => $this->gallery,
            'relatedProducts'      => $this->relatedProducts,
            'picture'              => (!empty($this->picture) ? $this->picture->toArray() : null),
            'categoryFeatureGroup' => $this->categoryFeatureGroup,
            'features'             => $this->features,
        ];
    }

    public function setDetails(\SimpleXMLElement $product)
    {
        $attr = $product->attributes();
        $this->id = (int) $attr['ID'];
        $this->code = (int) $attr['Code'];
        $this->prod_id = (string) $attr['Prod_id'];
        $this->name = (string) $attr['Name'];
        $this->title = (string) $attr['Title'];
        if ('' !== trim($attr['HighPic']) || '' !== trim($attr['ThumbPic'])) {
            $this->picture = new ProductPicture($product);
        }
    }

    protected function setBundled($bundled)
    {
        // @todo: add it later
    }

    /**
     * @param \SimpleXMLElement|false $category
     */
    protected function setCategory($category)
    {
        if (!empty($category) && $category instanceof \SimpleXMLElement) {
            $this->category = new Category($category);
        }
    }

    /**
     * @param array $categoryFeatureGroups
     */
    protected function setCategoryFeatureGroups($categoryFeatureGroups)
    {
        if (!empty($categoryFeatureGroups) && is_array($categoryFeatureGroups)) {
            foreach ($categoryFeatureGroups as $categoryFeatureGroup) {
                $this->categoryFeatureGroup[] = new FeatureGroup($categoryFeatureGroup);
            }
        }
    }

    protected function setDescription($description)
    {
        if (!empty($description) && $description instanceof \SimpleXMLElement) {
            $this->description = new Description($description);
        }
    }

    /**
     * @param array $eanCodes
     */
    protected function setEanCodes($eanCodes)
    {
        if (!empty($eanCodes) && is_array($eanCodes)) {
            foreach ($eanCodes as $eanCode) {
                $this->eanCode[] = new EANCode($eanCode);
            }
        }
    }

    protected function setFamily($family)
    {
        if (!empty($family) && $family instanceof \SimpleXMLElement) {
            $this->family = new Family($family);
        }
    }

    protected function setFeatureLogos($featureLogos)
    {
        if (!empty($featureLogos) && is_array($featureLogos)) {
            foreach ($featureLogos as $featureLogo) {
                $this->featureLogo[] = new Logo($featureLogo);
            }
        }
    }

    protected function setFeatures($features)
    {
        if (!empty($features) && is_array($features)) {
            foreach ($features as $feature) {
                $this->features[] = new Feature($feature);
            }
        }
    }

    protected function setGallery($gallery)
    {
        if (!empty($gallery) && count($gallery) > 0) {
            foreach ($gallery as $picture) {
                $this->gallery[] = new Picture($picture);
            }
        }
    }

    /**
     * ProductMultimediaObject
     *
     * 360 degree pictures (3D views)
     * Icecat catalog provide also with 3D (from 360 degrees) product reviews. 3D views can be found under <ProductMultimediaObject> tag of product XML.
     *
     * @example <MultimediaObject ContentType="application/x-shockwave-flash" Date="2015-03-14 00:55:27" Description="Product 3D" Height="0" IsRich="1" KeepAsURL="0" MultimediaObject_ID="2259784" PreviewHeight="0" PreviewSize="0" PreviewUrl="" PreviewWidth="0" Size="3327546" Type="360" URL="http://objects.icecat.biz/objects/5848283_1494.swf" UUID="2C464748-AA13-11E4-B614-599065C021B1" Width="0" langid="2"/>
     *
     * Energy efficiency information
     * Icecat fully complies with EU guidelines. We syndicate three content assets related to the energy label:
     * 1. The EU Energy Label
     * 2. The EU Product Datasheet (Product Fiche)
     * 3. The EU Energy Efficiency Class Logo, in the feature logo gallery (see arrow 2)
     *
     * @example <MultimediaObject ContentType="application/pdf" Date="2015-04-19 03:05:20" Description="Energy Label - Rainbow" Height="0" KeepAsURL="0" MultimediaObject_ID="2316652" PreviewHeight="0" PreviewSize="0" PreviewUrl="" PreviewWidth="0" Size="199544" Type="pdf" URL="http://objects.icecat.biz/objects/22191735_7703.pdf" UUID="FD1EC864-DCA3-11E4-A854-CFE34C01854C" Width="0" langid="4"/>
     *
     * Product videos
     * Product videos are represented in Icecat product XMLs under the <ProductMultimediaObject>. An example from XML is below:
     *
     * @example <MultimediaObject ContentType="video/mp4" Date="2015-04-28 13:15:36" Description="PaperStream Capture" Height="0" KeepAsURL="0" MultimediaObject_ID="1887453" OriginalMD5=""PreviewHeight="0" PreviewSize="0" PreviewUrl="http://objects.icecat.biz/objects/preview/20412312_1887453_preview.png" PreviewWidth="0" Size="20063974" ThumbUrl="http://objects.icecat.biz/objects/thumb/20412312_1887453_thumb.png" Type="video/mp4" URL="http://objects.icecat.biz/objects/20412312_1887453.mp4" UUID="279D6420-E7EE-11E3-8A19-9D7B6B607C7F" Width="0" langid="1"/>
     */
    protected function setMultimediaObjects()
    {
    }

    /**
     * Reasons to buy
     *
     * This type of content contains with:
     * - short textual reason name
     * - textual reason description
     * - it’s visual illustration (logo or just a picture)
     * In Icecat XML interface Reasons to buy is represented under <ReasonToBuy> tag:
     *
     * @example <ReasonToBuy ID="3443178" Value="The SmartControl software suite lets you remotely control and manage your network of displays via RJ45 and RS232C. Easily identify your displays and fine-tune all display settings including resolution, brightness, contrast, video wall configurations and cloning of your settings over your entire network."HighPic="http://images.icecat.biz/img/bullets/23205798-3443178.jpg" HighPicSize="40014" No="4" Title="SmartControl" langid="1"/>
     *
     * @param \SimpleXMLElement $reasons
     */
    protected function setReasonsToBuy($reasons)
    {
    }

    protected function setRelatedProducts($products)
    {
        if (!empty($products) && count($products) > 0) {
            if (count($products) == 1 && '' === (string) $products) {
                return false;
            }

            foreach ($products as $product) {
                $this->relatedProducts[] = new RelatedProduct($product);
            }
        }

        return true;
    }

    protected function setSummary($summary)
    {
        if (!empty($summary) && $summary instanceof \SimpleXMLElement) {
            $this->summary = new Summary($summary);
        }
    }
}
