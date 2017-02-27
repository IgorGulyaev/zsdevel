<?php

class Zen_Scroll_Block_Catalog_Product_List extends Mage_Catalog_Block_Product_List
{

    public function getArrayCollections()
    {
        $toolbar = $this->getToolbarBlock();

        $collection = $this->_getProductCollection();

        if ($orders = $this->getAvailableOrders()) {
            $toolbar->setAvailableOrders($orders);
        }
        if ($sort = $this->getSortBy()) {
            $toolbar->setDefaultOrder($sort);
        }
        if ($dir = $this->getDefaultDirection()) {
            $toolbar->setDefaultDirection($dir);
        }
        if ($modes = $this->getModes()) {
            $toolbar->setModes($modes);
        }

        $toolbar->setCollection($collection);

        $this->setChild('toolbar', $toolbar);
        Mage::dispatchEvent('catalog_block_product_list_collection', array(
            'collection' => $this->_getProductCollection()
        ));

        $this->_getProductCollection()->load();

        Mage::dispatchEvent('catalog_block_product_list_collection', array(
            'collection' => $this->_getProductCollection()
        ));

        parent::_getProductCollection()->load();

        $collection = parent::getLoadedProductCollection();

        $compare = Mage::helper('catalog/product_compare');
        $wishlist = Mage::helper('wishlist');
        $arrayCollection = array();
        $rendererBlock = Mage::getBlockSingleton('zen_all/product_renderer');

        foreach( $collection as $product ) {
            $arrayCollection[] = array(
                'productName' => $product->getName(),
                'productId' => $product->getId(),
                'productUrl' => $product->getProductUrl(),
                'productSmallImageUrl' => (string)Mage::helper('catalog/image')->init($product, 'small_image')->resize(300),
                'productPrice' => $rendererBlock->getPriceHtml($product, true),
                'productToCompare' => $compare->getAddUrl($product),
                'productWishList' => $wishlist->getAddUrl($product),
                'productDescription' => $product->getData('short_description')
            );
        }

        return $arrayCollection;
    }
}