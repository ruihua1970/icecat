<?php
namespace Icecat;

/**
 * Class Category
 *
 * @package Icecat
 * @author  Octavian Matei <octav@octav.name>
 * @since   31.10.2016
 */
class Category
{
    /** @var int */
    protected $id;

    /** @var int */
    protected $langId = 2;

    /** @var string */
    protected $name = '';

    /** @var string */
    protected $description = '';

    /** @var \Icecat\Category|null */
    protected $parentCategory = null;

    /** @var null|string */
    protected $picture = null;

    /** @var int */
    protected $score = 0;

    /** @var bool */
    protected $searchable = false;

    /** @var bool */
    protected $visible = false;

    /**
     * @param \SimpleXMLElement $category
     * @param null|int          $langId
     */
    public function __construct(\SimpleXMLElement $category, $langId = null)
    {
        if (!empty($langId)) {
            $this->langId = $langId;
        }

        $attr = $category->attributes();
        $this->id = (int) $attr['ID'];

        if (!empty($attr['Score'])) {
            $this->score = (int) $attr['Score'];
        }
        if (!empty($attr['Searchable'])) {
            $this->searchable = true;
        }
        if (!empty($attr['Visible'])) {
            $this->visible = true;
        }

        if (!empty($attr['LowPic'])) {
            $this->picture = (string) $attr['LowPic'];
        }

        if (count($category->ParentCategory) == 1) {
            $this->parentCategory = new \Icecat\Category($category->ParentCategory);
        }

        if (count($category->Description) > 0) {
            foreach ($category->Description as $description) {
                if ($this->langId == $description['langid']) {
                    $this->description = (string) $description['Value'];
                    break;
                }
            }
        }

        if (count($category->Name) == 1) {
            $this->name = (string) $category->Name['Value'];
        } else {
            foreach ($category->Name as $name) {
                if ($this->langId == $name['langid']) {
                    $this->name = (string) $name['Value'];
                    break;
                }
            }
        }

        if (count($category->Names) == 1 && count($category->Names->Name) > 0) {
            foreach ($category->Names->Name as $name) {
                if ($this->langId == $name['langid']) {
                    $this->name = (string) $name;
                    break;
                }
            }
        }
    }

    public function toArray()
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
        ];
    }
}
