<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Prutyan
 * Date: 12/21/2015
 * Time: 4:27 PM
 */

class Zen_All_Helper_Colors extends Mage_Core_Helper_Abstract {

    public function getThemeColorFirst(){
        return '#'.Mage::getStoreConfig('zen_all_options/theme/color_first_option');
    }
    public function getThemeColorSecond(){
        return '#'.Mage::getStoreConfig('zen_all_options/theme/color_second_option');
    }
    public function getThemeColorThird(){
        return '#'.Mage::getStoreConfig('zen_all_options/theme/color_third_option');
    }
    public function getThemeColorFourth(){
        return '#'.Mage::getStoreConfig('zen_all_options/theme/color_fourth_option');
    }
}