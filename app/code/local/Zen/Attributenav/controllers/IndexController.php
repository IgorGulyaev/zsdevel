<?php

class Zen_Attributenav_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $params = $this->getRequest()->getParams();

        if ( ($this->getRequest()->isXmlHttpRequest() &&  isset($params['scroll'])) && !isset($params['aw_layerednavigation'])  ) {

            $this->loadLayout();

            $productList = $this->getLayout()->getBlock('product_list');
            $arrayCollections = $productList->getArrayCollections();

            $response = ['collection' => $arrayCollections];

            $toolbarHtml = $productList->getChild('toolbar')->toHtml();

            $response['toolbar'] = $toolbarHtml;
            $response['nav'] = $this->getLayout()->getBlock('catalog.leftnav')->toHtml();

            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));

        } else {
            $this->loadLayout();
            $this->renderLayout();
        }
    }
}