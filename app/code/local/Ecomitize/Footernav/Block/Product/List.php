<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Prutian
 * Date: 12/22/2015
 * Time: 1:02 PM
 */

class Ecomitize_Footernav_Block_Product_List extends Ecomitize_Scroll_Block_Catalog_Product_List{

    /**
     * Retrieve loaded category collection
     *_
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected function _getProductCollection()
    {
        $route = Mage::app()->getRequest()->getRouteName();
        if($route == 'offers'){
            if (is_null($this->_productCollection))
            {
                $layer = $this->getLayer();
                $productCollection = $layer->getProductCollection();
                $this->_productCollection = $productCollection;
            }
            return $this->_productCollection;
        }
        else{
            return parent::_getProductCollection();
        }
    }
}