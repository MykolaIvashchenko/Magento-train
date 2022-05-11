<?php
/**
 * Copyright © Magebit, Inc. All rights reserved.
 * See COPYING.txt for license details.
 *
 * This class extends \Magento\Catalog\Block\Product\View\Attributes and add filters to attributes block
 */
namespace Magebit\Helpers\Block\Product\View;

use \Magento\Framework\Phrase;

class Attributes extends \Magento\Catalog\Block\Product\View\Attributes
{
    const ATTRIBUTES_COUNT = 3;

    public function getAdditionalData(array $excludeAttr = [])
    {
        $data = [];
        $product = $this->getProduct();
        $attributes = $product->getAttributes();

        foreach ($attributes as $attribute) {
            if ($this->isVisibleOnFrontend($attribute, $excludeAttr)) {
                $value = $attribute->getFrontend()->getValue($product);

                if ($value instanceof Phrase) {
                    $value = (string)$value;
                } elseif ($attribute->getFrontendInput() == 'price' && is_string($value)) {
                    $value = $this->priceCurrency->convertAndFormat($value);
                }

                if (is_string($value) && strlen(trim($value))) {
                    $data[$attribute->getAttributeCode()] = [
                        'label' => $attribute->getStoreLabel(),
                        'value' => $value,
                        'code' => $attribute->getAttributeCode(),
                    ];
                }
            }
        }

        $data = $this->attributesFilter($data);

        return $data;
    }

    /**
     * method for attribute filtering.
     * Displays a maximum of ATTRIBUTES_COUNT attributes.
     * Color, dimensions and material.
     * If any attribute is missing, it replaces the third attribute with some other one.
     */

    private function attributesFilter(array $attributes): array
    {


        $attributesResult = [];
        $attributesCodes = [
            'dimensions',
            'colour',
            'material'
        ];

        foreach ($attributes as $key => $attribute){
            if(in_array($key, $attributesCodes)){
                $attributesResult[$key] = $attribute;
                unset($attributes[$key]);
            }
        }

        if(count($attributesResult) < self::ATTRIBUTES_COUNT){
            $counter = count($attributesResult);

            foreach ($attributes as $key => $attribute){
                if($counter >= self::ATTRIBUTES_COUNT){break;}
                $attributesResult[$key] = $attribute;
                unset($attributes[$key]);
                $counter++;
            }
        }

        return $attributesResult;
    }

}
