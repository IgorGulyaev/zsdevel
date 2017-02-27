<?php
class Zen_Popup_Model_Options_Speed
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'0.4', 'label'=>Mage::helper('zen_popup')->__('fast')),
            array('value'=>'1.0', 'label'=>Mage::helper('zen_popup')->__('normal')),
            array('value'=>'1.6', 'label'=>Mage::helper('zen_popup')->__('slow')),
        );
    }
}