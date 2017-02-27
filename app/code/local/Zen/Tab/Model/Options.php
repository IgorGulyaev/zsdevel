<?php
class Zen_Tab_Model_Options {

    public function toOptionArray() {
        return [
            ['value' => 'featured', 'label' => Mage::helper('zen_all')->__('Featured')],
            ['value' => 'viewed', 'label' => Mage::helper('zen_all')->__('Viewed')],
            ['value' => 'sale', 'label' => Mage::helper('zen_all')->__('Special Offers')],
            ['value' => 'news', 'label' => Mage::helper('zen_all')->__('News')],
        ];
    }
}