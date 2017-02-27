<?php

class Zen_All_Model_OptionsButton
{
    public function toOptionArray()
    {
        return array(
            array('value'=>true, 'label'=>Mage::helper('zen_all')->__('Infinite')),
            array('value'=>false, 'label'=>Mage::helper('zen_all')->__('Button')),
        );
    }

}