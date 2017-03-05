<?php
namespace Df\GingerPaymentsBase;
use Magento\Sales\Model\Order\Address as OA;
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
		'address' => 'Amsterdam Rusland 17'
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
		,'birth_date' => '1982-07-08 00:00:00'
		,'country' => $a->getCountryId()
		,'email_address' => $this->customerEmail()
		,'first_name' => $this->customerNameF()
		,'forwarded_ip' => '5.9.188.84'
		// "male", "female", "other", null
		,'gender' => $this->customerGender('male', 'female')
		,'housenumber' => '17'
		,'ip_address' => '5.9.188.84'
		,'last_name' => 'Fedyuk'
		// 2017-02-28
		// [Kassa Compleet] What is the right format of a customer's locale in a «POST /v1/orders/» request?
		// https://mage2.pro/t/3444
		// [Ginger Payments] The «customer/locale» property is absent in the JSON Schema
		// of a «POST /v1/orders/» request, but is passed by the official extension for Magento 1.x:
		// https://mage2.pro/t/3443
		// The official Ginger Payments and Kassa Compleet extensions for Magento 1.x
		// pass the same customer data to «POST /v1/orders/» besides the «customer/locale» format:
		// https://mage2.pro/t/3445
		,'locale' => 'nl_NL'
		,'merchant_customer_id' => '123'
		,'phone_numbers' => ['+31 20 623 1231']
		// 2017-02-28
		// Test addresses for some countries: https://mage2.pro/t/2555
		,'postal_code' => '1012'
		,'referrer' => 'https://mage2.pro'
		,'user_agent' => 'Mage2.PRO'
	];}


	/**
	 * 2017-03-06
	 * @used-by \Df\PaypalClone\Method::getConfigPaymentAction()
	 * @param Method $m
	 * @return array(string, array(string => mixed))
	 */
	static function p(Method $m) {return (new self([self::$P__METHOD => $m]))->pCharge();}
}