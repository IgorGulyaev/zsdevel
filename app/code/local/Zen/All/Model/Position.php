<?php

class Zen_All_Model_Position
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'default', 'label'=>Mage::helper('zen_all')->__('Default')),
            array('value'=>'fixed', 'label'=>Mage::helper('zen_all')->__('Fixed')),
        );
    }

}