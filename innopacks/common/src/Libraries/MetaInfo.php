<?php
/* */

namespace InnoShop\Common\Libraries;

use Illuminate\Support\Str;

class MetaInfo
{
    private object $object;

    private string $type;

    /**
     * @param  $object
     */
    public function __construct($object)
    {
        $this->object = $object;
        $this->setType();
    }

    public static function getInstance($object): MetaInfo
    {
        return new self($object);
    }

    /**
     * @return MetaInfo
     */
    public function setType(): static
    {
        $this->type = Str::lower(class_basename($this->object));

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        $metaTitle = $this->object->translation->meta_title ?? '';
        if (empty($metaTitle)) {
            $metaTitle = $this->getName();
        }

        return $metaTitle;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        $metaDescription = $this->object->translation->meta_description ?? '';
        if (empty($metaDescription)) {
            $metaDescription = $this->getName();
        }

        return $metaDescription;
    }

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        $metaKeywords = $this->object->translation->meta_keywords ?? '';
        if (empty($metaKeywords)) {
            $metaKeywords = $this->getName();
        }

        return $metaKeywords;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        $object = $this->object;
        $type   = $this->type;
        if (in_array($type, ['category', 'product', 'tag'])) {
            return $object->fallbackName('name');
        } elseif (in_array($type, ['catalog', 'article', 'page'])) {
            return $object->fallbackName('title');
        } elseif ($type == 'brand') {
            return $object->name;
        }

        return '';
    }
}
