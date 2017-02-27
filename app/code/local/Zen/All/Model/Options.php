<?php

class Zen_All_Model_Options
{
    public function toOptionArray()
    {
        return array(
            array('value'=>true, 'label'=>Mage::helper('zen_all')->__('Enable')),
            array('value'=>false, 'label'=>Mage::helper('zen_all')->__('Disable')),
        );
    }

}