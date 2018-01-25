<?php
# Controllers are not autoloaded so we will have to do it manually: 
require_once 'Mage/Checkout/controllers/OnepageController.php';
class Lalatteria_Postcode_OnepageController extends Mage_Checkout_OnepageController
{
	

	public function saveBillingAction()
	{
			if ($this->_expireAjax()) {
				return;
			}
			
		if ($this->getRequest()->isPost()) {
				$data = $this->getRequest()->getPost('billing', array());
                                
                                //APPNOVA
                                //Check only if this address is used for shipping also
                                $useForShipping = '0';
                                if (isset($data['use_for_shipping'])) {
                                   $useForShipping = $data['use_for_shipping'];
                                }
                                /*if ('0' == $useForShipping){
                                   return parent::saveBillingAction();
                                }*/

				$customerAddressId = $this->getRequest()->getPost('billing_address_id', false);

        if (!empty($customerAddressId)) {
            $customerAddress = Mage::getModel('customer/address')->load($customerAddressId);
            if ($customerAddress->getId()) {

              $data['postcode'] = $customerAddress->getPostcode();
            }
        }

				if (isset($data['email'])) {
					$data['email'] = trim($data['email']);
				}
				if (isset($data['postcode'])) {
					$data['postcode'] = trim($data['postcode']);
				}
				$dest_zip	= $data['postcode'];
				if ((substr($dest_zip, 0, 1) === '_') || (preg_match('/^[a-z]+__[a-z]+$/i', $dest_zip))) 
				{
					$result['error']	=	true;
					$result['message']	=	'Sorry, Invalid Zip Code.';
				}
				else{
					if(preg_match("/^(([A-PR-UW-Z]{1}[A-IK-Y]?)([0-9]?[A-HJKS-UW]?[ABEHMNPRVWXY]?|[0-9]?[0-9]?))\s?([0-9]{1}[ABD-HJLNP-UW-Z]{2})$/i",$dest_zip,$postcode,PREG_OFFSET_CAPTURE)) 
					{
						$getPostcode = $postcode;
					}
					if(!isset($getPostcode)){
						$result['error']	=	true;
						$result['message']	=	'Provided Zip/Postal Code seems to be invalid. Example: AB12 3CD; A1B 2CD; AB1 2CD; AB1C 2DF; A12 3BC; A1 2BC.'; // . ' :: ' . $dest_zip;
					}
					else{
					
					$connection = $this->_getConnection('core_read');
					$tblname 	= $this->_getTableName('shipping_matrixrate');
					//$regex = "REGEXP '[[:<:]]".$dest_zip."[[:>:]]'";
					$sql 		= $connection->query("SELECT * FROM $tblname  WHERE '$dest_zip' LIKE `dest_zip`");
					/*$sql1 		= $connection->query("SELECT * FROM $tblname  WHERE `dest_zip` LIKE '$dest_zip%'");
					
					$data1		=	array();
					while ($row1 = $sql1->fetch()) {
						$data1[] = $row1["dest_zip"];
					}*/
					
					$data2		=	array();
					while ($row = $sql->fetch()) {
						$data2[] = $row["dest_zip"];
					}
					
					if(!$useForShipping || count($data2) >= 1){
						$result = $this->getOnepage()->saveBilling($data, $customerAddressId);
						if (!isset($result['error'])) {
							if ($this->getOnepage()->getQuote()->isVirtual()) {
								$result['goto_section'] = 'payment';
								$result['update_section'] = array(
									'name' => 'payment-method',
									'html' => $this->_getPaymentMethodsHtml()
								);
							} elseif (isset($data['use_for_shipping']) && $data['use_for_shipping'] == 1) {
								$result['goto_section'] = 'shipping_method';
								$result['update_section'] = array(
									'name' => 'shipping-method',
									'html' => $this->_getShippingMethodsHtml()
								);

								$result['allow_sections'] = array('shipping');
								$result['duplicateBillingInfo'] = 'true';
							} else {
								$result['goto_section'] = 'shipping';
							}
						}
					}
					/*elseif((count($data2)==0) && (count($data1) >= 1)){
						$result['error']		= true;
						$result['message']	=	'Please enter full zip code.';
					}*/
					else{
                                                //APPNOVA
                                                //Disabled: (Still saving but going to shipping)
                                                $_POST['billing[use_for_shipping]'] = '0';
                                                $data['use_for_shipping'] = '0';
                                                $result = $this->getOnepage()->saveBilling($data, $customerAddressId);

                                                if($useForShipping && 0 == count($data2)) {
						  $result['error']	=	true;
						  $result['message']	=	"We do not ship to your post code, please select a different shipping address..." . substr($dest_zip, 0, 10);
						}
                                                //$result['goto_section'] = 'shipping';
                                                $result['duplicateBillingInfo'] = 'false';
                                                 
                                                if ($this->getOnepage()->getQuote()->isVirtual()) {
                                                           $result['error'] = false; //No need of shipping zip
                                                           $result['goto_section'] = 'payment';
                                                           $result['update_section'] = array(
                                                                    'name' => 'payment-method',
                                                                    'html' => $this->_getPaymentMethodsHtml()
                                                           );
                                                }
                                                
					}
				}
				}
				$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));			
		}
	}


    /**
     * Shipping address save action
     */
    public function saveShippingAction()
    {
        if ($this->_expireAjax()) {
            return;
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('shipping', array());
				
			$customerAddressId = $this->getRequest()->getPost('shipping_address_id', false);

        if (!empty($customerAddressId)) {
            $customerAddress = Mage::getModel('customer/address')->load($customerAddressId);
            if ($customerAddress->getId()) {

              $data['postcode'] = $customerAddress->getPostcode();
            }
        }

			if (isset($data['postcode'])) {
				$data['postcode'] = trim($data['postcode']);
			}
			$dest_zip	= $data['postcode'];

			if ((substr($dest_zip, 0, 1) === '_') || (preg_match('/^[a-z]+__[a-z]+$/i', $dest_zip))) 
				{
					$result['error']	=	true;
					$result['message']	=	'Sorry, Invalid Zip Code.';
				}
				else{
					if(preg_match("/^(([A-PR-UW-Z]{1}[A-IK-Y]?)([0-9]?[A-HJKS-UW]?[ABEHMNPRVWXY]?|[0-9]?[0-9]?))\s?([0-9]{1}[ABD-HJLNP-UW-Z]{2})$/i",$dest_zip,$postcode,PREG_OFFSET_CAPTURE)) 
					{
									$getPostcode = $postcode;
					}
					if(!isset($getPostcode)){
					$result['error']	=	true;
					$result['message']	=	'Provided Zip/Postal Code seems to be invalid. Example: AB12 3CD; A1B 2CD; AB1 2CD; AB1C 2DF; A12 3BC; A1 2BC.';
					}
					else
					{
					$connection = $this->_getConnection('core_read');
					$tblname 	= $this->_getTableName('shipping_matrixrate');
					//$regex = "REGEXP '[[:<:]]".$dest_zip."[[:>:]]'";
					$sql 		= $connection->query("SELECT * FROM $tblname  WHERE '$dest_zip' LIKE `dest_zip`");
					$sql1 		= $connection->query("SELECT * FROM $tblname  WHERE `dest_zip` LIKE '$dest_zip%'");
					
					$data1		=	array();
					while ($row1 = $sql1->fetch()) {
						$data1[] = $row1["dest_zip"];
					}
					
					$data2		=	array();
					while ($row = $sql->fetch()) {
						$data2[] = $row["dest_zip"];
					}
					if(count($data2)>0){
						$result = $this->getOnepage()->saveShipping($data, $customerAddressId);

						if (!isset($result['error'])) {
							$result['goto_section'] = 'shipping_method';
							$result['update_section'] = array(
								'name' => 'shipping-method',
								'html' => $this->_getShippingMethodsHtml()
							);
						}
					}
					elseif((count($data2)==0) && (count($data1) >= 1)){
						$result['error']		= true;
						$result['message']	=	'Please enter full zip code.';
					}
					else{
						$result['error']	=	true;
						$result['message']	=	'Sorry, delivery is not possible yet, but our delivery services are rapidly expanding.';
					}
				}				
			}
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        }
    }
	
// for database connection
	protected function _getConnection($type = 'core_read'){
		return Mage::getSingleton('core/resource')->getConnection($type);
	}
//for table selection
	protected function _getTableName($tableName){
		return Mage::getSingleton('core/resource')->getTableName($tableName);
	}
}
