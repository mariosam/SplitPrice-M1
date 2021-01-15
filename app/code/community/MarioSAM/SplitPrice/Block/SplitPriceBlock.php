<?php
/**
 * Class SplitPriceBlock
 * 
 * @author      MarioSAM <eu@mariosam.com.br>
 * @version     1.0.0
 * @date        2021/01
 * @copyright   Blog do Mario SAM
 * 
 * This class collect the data to show them in frontend.
 */

class MarioSAM_SplitPrice_Block_SplitPriceBlock extends Mage_Core_Block_Template
{
    /**
     * SplitPriceBlock constructor.
     *
     */
    protected function _construct()
    {
        parent::_construct();
    }

    /***************************************************************************
     *  GENERAL CONFIG
     */

    /**
     * Check if this module is active or not.
     * 
     * @return boolean
     */
    public function getEnabled()
    {
        return Mage::getStoreConfig('splitprice/split_price_config/enabled');
    }

    /**
     * Get the price value of Product page detail
     *   
     * @return double
     */
    public function getProductPrice()
    {
        $currentProduct = Mage::registry('current_product');

        //seria melhor usar uma constante nativa, mas nao encontrei.
        if ('configurable' == $currentProduct->getTypeId()) {
            return $currentProduct->getFinalPrice();
        }

        if ('bundle' == $currentProduct->getTypeId()) {
            $_priceModel = $currentProduct->getPriceModel();
            list($_minimalPriceTax, $_maximalPriceTax) = $_priceModel->getTotalPrices($currentProduct, null, null, false);

            return $_minimalPriceTax;
        }

        if ('grouped' == $currentProduct->getTypeId()) {
            $regularPrice = 0;
            $usedProds = $currentProduct->getTypeInstance(true)->getAssociatedProducts($currentProduct);            
            foreach ($usedProds as $child) {
                if ($child->getId() != $currentProduct->getId()) {
                    $regularPrice += $child->getPrice();
                }
            }
            return $regularPrice;
        }

        return $currentProduct->getFinalPrice();
    }
    
    /**
     * 
     * @return type
     */
    public function getCartPrice()
    {
        return Mage::getSingleton("checkout/cart")->getQuote()->getGrandTotal();
    }
    
    //nao ta sendo usado, foi lido a pagina usando jquery
    public function getListPrice()
    {
        return 0;
    }

    /**
     * Get the maximum numbers of splits
     * 
     * @return int
     */
    public function getProductPriceX()
    {
        return Mage::getStoreConfig('splitprice/split_price_config/maximum_splits');
    }
    
    /**
     * If to show all splits values
     * 
     * @return boolean
     */
    public function getProductPriceAll()
    {
        return Mage::getStoreConfig('splitprice/split_price_config/show_all');
    }
    
    /**
     * Get the tax value if exist
     * 
     * @return int
     */
    public function getProductPriceTax()
    {
        $_tax = Mage::getStoreConfig('splitprice/split_price_config/add_tax');
        
        if (!ctype_digit($_tax))
        {
            $_tax = 0;
        }
        
        return $_tax;
    }
    
    /**
     * What kind of price need to be calculate
     * 
     * @return text
     */
    public function getProductPriceType()
    {
        return Mage::getStoreConfig('splitprice/split_price_config/base_price');
    }
    
    /***************************************************************************
     * CUSTOM CONFIGURATION
     */
    
    /**
     * Show the split prices in catalog list pages
     * 
     * @return boolean
     */
    public function getShowInCatalog()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/show_catalog');
    }

    /**
     * CSS place to insert the message in catalog list pages 
     * 
     * @return text
     */
    public function getCatalogPosition()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/show_catalog_position');
    }

    /**
     * Show the split prices in product detail page
     * 
     * @return boolean
     */
    public function getShowInProduct()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/show_product');
    }

    /**
     * CSS place to insert the message in product detail page
     * 
     * @return text
     */
    public function getProductPosition()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/show_product_position');
    }
    
    /**
     * Show the split prices in shopping cart page
     * 
     * @return boolean
     */
    public function getShowInCart()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/show_cart');
    }

    /**
     * CSS place to insert the message in shopping cart page
     * 
     * @return text
     */
    public function getCartPosition()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/show_cart_position');
    }
    
    /**
     * Get custom css code to improve frontend catalog list.
     * 
     * @return textarea
     */
    public function getCssCustomCatalog()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/css_catalog');
    }
    
    /**
     * Get custom javascript code to improve frontend catalog list.
     * 
     * @return textarea
     */
    public function getJsCustomCatalog()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/js_catalog');
    }
    
    /**
     * Get custom css code to improve frontend product page.
     * 
     * @return textarea
     */
    public function getCssCustomProduct()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/css_product');
    }
    
    /**
     * Get custom javascript code to improve frontend product page.
     * 
     * @return textarea
     */
    public function getJsCustomProduct()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/js_product');
    }
    
    /**
     * Get custom css code to improve frontend shopping cart.
     * 
     * @return textarea
     */
    public function getCssCustomCart()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/css_cart');
    }
    
    /**
     * Get custom javascript code to improve frontend shopping cart.
     * 
     * @return textarea
     */
    public function getJsCustomCart()
    {
        return Mage::getStoreConfig('splitprice/split_price_presentation/js_cart');
    }
}