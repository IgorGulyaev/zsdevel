<?php
class Zen_Popup_Model_Options_Videofrom
{
    public function toOptionArray()
    {
        return array(
            array('value'=>'youtube', 'label'=>Mage::helper('zen_popup')->__('youtube')),
            array('value'=>'vimeo', 'label'=>Mage::helper('zen_popup')->__('vimeo')),
        );
    }
}