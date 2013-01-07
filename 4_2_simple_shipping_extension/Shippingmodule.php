<?php
/**
 * Shippingmodule.php
 *
 * PHP file for implementing the new shipping model in the cart and checkout.
 *
 * @method YourCompany_NewModule_Model_Carrier_Newmodule collectRates(Mage_Shipping_Model_Rate_Request $request)
 * @method array getAllowedMethods()
 *
 * @author      Chuck Hudson
 */

class RubberDucky_ShippingModule_Model_Carrier_Shippingmodule extends Mage_Shipping_Model_Carrier_Abstract
{
	
	 /**
	 * Code of the carrier
	 *
	 * @var string
	 */
	const CODE = 'shippingmodule';

	/**
	 * Code of the carrier
	 *
	 * @var string
	 */
	protected $_code = self::CODE;

  /**
   * Collect the rates for this shipping method to display.
	 *
   * @param Mage_Shipping_Model_Rate_Request $request
   * @return Mage_Shipping_Model_Rate_Result
   */
  public function collectRates(Mage_Shipping_Model_Rate_Request $request)
  {
		
    // Return now if this carrier is not active in the configured shipping methods.
    if (!Mage::getStoreConfig('carriers/'.$this->_code.'/active')) {
        return false;
    }
 
    // Create the container for holding rates for this shipping method.
		$result = Mage::getModel('shipping/rate_result');
		
    // Get the configured shipping method settings (base fee and percentage add of subtotal).
    $slow_boat_base_fee = Mage::getStoreConfig('carriers/'.$this->_code.'/slow_boat_base_fee');
    $slow_boat_percent = Mage::getStoreConfig('carriers/'.$this->_code.'/slow_boat_percent');
    $fast_plane_base_fee = Mage::getStoreConfig('carriers/'.$this->_code.'/fast_plane_base_fee');
    $fast_plane_percent = Mage::getStoreConfig('carriers/'.$this->_code.'/fast_plane_percent');
		
		// Retrieve the cart subtotal for calculating additional percentage.
		$subtotal = $this->_getCartSubtotal();
				
		// Calculate the "Slow Boat" method rate and append to the collection.
		$rate = Mage::getModel('shipping/rate_result_method');
		$rate->setCarrier($this->_code);
		$rate->setCarrierTitle($this->getConfigData('title'));
		$rate->setMethod('slowboat'); 
		$rate->setMethodTitle('Slow Boat');
		$rate->setCost($slow_boat_base_fee);
		$rate->setPrice(number_format($slow_boat_base_fee+($subtotal*$slow_boat_percent)),2);
		$result->append($rate);
		
		// Calculate the "Fast Plane" method rate and append to the collection.
		$rate = Mage::getModel('shipping/rate_result_method');
		$rate->setCarrier($this->_code);
		$rate->setCarrierTitle($this->getConfigData('title'));
		$rate->setMethod('fastplane'); 
		$rate->setMethodTitle('Fast Plane');
		$rate->setCost($fast_plane_base_fee);
		$rate->setPrice(number_format($fast_plane_base_fee+($subtotal*$fast_plane_percent)),2);
		$result->append($rate);
 
		// Return the collection of shipping rates for display.
    return $result;
  }
 
 	/**
	 * Get order subtotal
	 *
	 * @return float
	 */
	protected function _getCartSubtotal()
	{
		// Retrieve the totals of the current cart.
		$cartTotals = Mage::getSingleton('checkout/cart')->getQuote()->getTotals();
		// Get the subtotal value from the totals array.
		$cartSubtotal = $cartTotals["subtotal"]->getValue();
		return $cartSubtotal;
	}
		
	/**
	 * Get allowed shipping methods
	 *
	 * @return array
	 */
  public function getAllowedMethods() 
	{
    return array($this->_code => $this->getConfigData('name'));
  }
}
?>