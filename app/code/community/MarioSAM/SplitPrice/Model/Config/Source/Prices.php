<?php
/**
 * Class Prices
 * 
 * @author      MarioSAM <eu@mariosam.com.br>
 * @version     1.0.0
 * @date        2021/01
 * @copyright   Blog do Mario SAM
 * 
 * Give the new options value to config the system module.
 */
class MarioSAM_SplitPrice_Model_Config_Source_Prices
{ 
    /**
     * Return array of options as value-label pairs, eg. value => label
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value'=>'base-price', 'label'=>__('Base Price Only')),
            array('value'=>'promo-price', 'label'=>__('Promo Price Only')),
            array('value'=>'promo-first', 'label'=>__('Promo Price (if exist) > Base Price'))
        );
    }
}
