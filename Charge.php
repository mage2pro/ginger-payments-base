<?php
namespace Df\GingerPaymentsBase;
use Magento\Sales\Model\Order\Address as OA;
use Magento\Sales\Model\Order\Item as OI;
/**
 * 2017-03-05
 * @method Method m()
 * @method Settings ss()
 */
final class Charge extends \Df\Payment\Charge {
	/**
	 * 2017-03-06
	 * @used-by p()
	 * @return array(string => mixed)
	 */
	private function pCharge() {return [
		// 2017-02-27
		// «Order amount (including VAT)».
		'amount' => $this->amountF()
		// 2017-02-28
		// The «client» property is present only in the Kassa Compleet's JSON schema,
		// but Ginger Payments does not fail if it is specified (just silently ignores it).
		,'client' => $this->pClient()
		// 2017-02-28
		// [Ginger Payments] A documentation for the «customer» parameter
		// in the «POST /v1/orders/» request: https://mage2.pro/t/3394
		// The official Ginger Payments and Kassa Compleet extensions for Magento 1.x
		// pass the same customer data to «POST /v1/orders/» besides the «customer/locale» format:
		// https://mage2.pro/t/3445
		,'customer' => $this->pCustomer()
		// 2017-02-27
		// The currency
		,'currency' => $this->currencyC()
		// 2017-02-27
		// «A description (optional)»
		// I did not find any limitations on it.
		,'description' => $this->description()
		// 2017-02-27
		// The expiration period in ISO 8601 format (optional)
		// [Ginger Payments] The «expiration_period» parameter for POST /v1/orders/ is undocumented: https://mage2.pro/t/3388
		,'expiration_period' => 'PT15M'
		// 2017-02-28
		// Arbitrary data.
		,'extra' => $this->metadata()
		// 2017-02-27
		// Your identifier for the order (optional)
		,'merchant_order_id' => $this->oii()
		// 2017-02-28
		// [Ginger Payments] Is any documentation on the «order_lines» property
		// of the «POST /v1/orders/» request? https://mage2.pro/t/3450
		,'order_lines' => $this->pOrderLines()
	];}

	/**
	 * 2017-03-06
	 * @used-by pCharge()
	 * @return array(string => mixed)
	 */
	private function pClient() {return [
		'platform_name' => "Mage2.PRO «{$this->m()->titleB()}» extension for Magento 2 (https://mage2.pro)"
		,'platform_version' => df_package_version($this->m())
		// 2017-02-28
		// It will be rewritten to «Ginger-Python-ApiClient/0.8.1 Requests/2.11.1 Python/2.7.10».
		,'user_agent' => 'Mage2.PRO (https://mage2.pro)'
	];}

	/**
	 * 2017-03-06
	 * @used-by pCharge()
	 * @return array(string => string|string[])
	 */
	private function pCustomer() {/** @var OA $a */ $a = $this->addressBS(); return [
		// 2017-02-28
		// Test addresses for some countries: https://mage2.pro/t/2555
		'address' => df_cc_s($a->getStreet())
		,'address_type' => 'billing'
		// 2017-02-28
		// [Kassa Compleet] What is the right format of a customer's birth date in a «POST /v1/orders/» request?
		// https://mage2.pro/t/3448
		// [Kassa Compleet] The «customer/birth_date» property is absent in the JSON Schema
		// of a «POST /v1/orders/» request, but is passed by the official extension for Magento 1.x:
		// https://mage2.pro/t/3447
		// [Ginger Payments] The «customer/birth_date» property is absent in the JSON Schema
		// of a «POST /v1/orders/» request, but is passed by the official extension for Magento 1.x:
		// https://mage2.pro/t/3446
		,'birth_date' => $this->customerDobS(\Zend_Date::ISO_8601)
		,'country' => $a->getCountryId()
		,'email_address' => $this->customerEmail()
		,'first_name' => $this->customerNameF()
		,'forwarded_ip' => $this->customerIp()
		// "male", "female", "other", null
		,'gender' => $this->customerGender('male', 'female')
		,'housenumber' => ''
		,'ip_address' => $this->customerIp()
		,'last_name' => $this->customerNameL()
		// 2017-02-28
		// [Kassa Compleet] What is the right format of a customer's locale in a «POST /v1/orders/» request?
		// https://mage2.pro/t/3444
		// [Ginger Payments] The «customer/locale» property is absent in the JSON Schema
		// of a «POST /v1/orders/» request, but is passed by the official extension for Magento 1.x:
		// https://mage2.pro/t/3443
		// The official Ginger Payments and Kassa Compleet extensions for Magento 1.x
		// pass the same customer data to «POST /v1/orders/» besides the «customer/locale» format:
		// https://mage2.pro/t/3445
		,'locale' => $this->locale()
		,'merchant_customer_id' => $this->o()->getCustomerId() ?: $this->customerName()
		,'phone_numbers' => df_clean([$a->getTelephone()])
		// 2017-02-28
		// Test addresses for some countries: https://mage2.pro/t/2555
		,'postal_code' => $a->getPostcode()
		// 2017-03-06
		// I did it intentionally.
		,'referrer' => 'https://mage2.pro'
		,'user_agent' => 'Mage2.PRO'
	];}

	/**
	 * 2017-03-06
	 * @used-by pCharge()
	 * @return array(string => string|int|float)
	 */
	private function pOrderLines() {return $this->oiLeafs(function(OI $i) {return [
		'amount' => 1250
		,'currency' => $this->currencyC()
		,'discount_rate' => 0
		,'ean' => '12345'
		,'id' => '1'
		,'image_url' => 'https://mage2.pro/uploads/default/original/1X/ed63ec02f0651856b03670a04b03057758b4c8e8.png'
		,'merchant_order_line_id' => '11'
		,'name' => 'An order item'
		,'quantity' => 2
		,'url' => 'https://mage2.pro'
		,'type' => 'physical'
		// 2017-02-28
		// Kassa Compleet and Ginger Payments use different formats
		// for the «order_lines/order_line/vat_percentage» property
		// of a «POST /v1/orders/» request: https://mage2.pro/t/3451
		,'vat_percentage' => 17.5 * $this->m()->vatFactor()
	];});}

	/**
	 * 2017-03-06
	 * @used-by \Df\PaypalClone\Method::getConfigPaymentAction()
	 * @param Method $m
	 * @return array(string, array(string => mixed))
	 */
	static function p(Method $m) {return (new self([self::$P__METHOD => $m]))->pCharge();}
}