<?php
namespace Df\GingerPaymentsBase\T;
/**
 * 2017-02-27
 * @see \Dfe\GingerPayments\T\CreateOrder
 * @see \Dfe\KassaCompleet\T\CreateOrder
 */
abstract class CreateOrder extends TestCase {
	/**
	 * 2017-02-27
	 * @used-by t01_success()
	 * @see \Df\GingerPaymentsBase\T\CreateOrder\Ideal::method()
	 * @return string
	 */
	abstract protected function method();

	/**
	 * @test
	 * 2017-02-27
	 * [Ginger Payments] Which parameters can be passed to «POST /v1/orders/»? https://mage2.pro/t/3389
	 * [Ginger Payments] A JSON Schema of a «POST /v1/orders/» request: https://mage2.pro/t/3410
	 * [Kassa Compleet] A JSON Schema of a «POST /v1/orders/» request: https://mage2.pro/t/3411
	 */
	final function t01_success() {
		$this->api()->postOrder([
			// 2017-02-27
			// The amount in cents
			'amount' => 2500
			// 2017-02-28
			// [Ginger Payments] A documentation for the «customer» parameter
			// in the «POST /v1/orders/» request: https://mage2.pro/t/3394
			// The official Ginger Payments and Kassa Compleet extensions for Magento 1.x
			// pass the same customer data to «POST /v1/orders/» besides the «customer/locale» format:
			// https://mage2.pro/t/3445
			,'customer' => $this->customer()
			// 2017-02-27
			// The currency
			,'currency' => 'EUR'
			// 2017-02-27
			// «A description (optional)»
			// I did not find any limitations on it.
			,'description' => 'Пример <b>описания</b> <a href="https:://mage2.pro">заказа</a> د ويکيپېډيا، وړیا پوهنغونډ له خوا 묘사(描寫)는 사물의'
			// 2017-02-27
			// The expiration period in ISO 8601 format (optional)
			// [Ginger Payments] The «expiration_period» parameter for POST /v1/orders/ is undocumented: https://mage2.pro/t/3388
			,'expiration_period' => 'PT15M'
			// 2017-02-27
			// Your identifier for the order (optional)
			,'merchant_order_id' => 'order-234192'
			// 2017-02-27
			// «The return URL (optional)».
			// This parameter is required for iDEAL:
			// https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#creating-an-ideal-order
			// https://www.gingerpayments.com/docs#creating-an-ideal-order
			,'return_url' => 'https://mage2.pro'
			,'transactions' => [[
				// 2017-02-27
				// The payment method
				'payment_method' => $this->method()
				// 2017-02-27
				// Extra details required for this payment method
				,'payment_method_details' => $this->params()
			]]
		]);
		echo $this->api()->lastResponse();
	}

	/**
	 * 2017-02-27
	 * @used-by t01_success()
	 * @see \Df\GingerPaymentsBase\T\CreateOrder\Ideal::params()
	 * @return string
	 */
	protected function params() {return [];}

	/**
	 * 2017-02-28
	 * The official Ginger Payments and Kassa Compleet extensions for Magento 1.x
	 * pass the same customer data to «POST /v1/orders/» besides the «customer/locale» format:
	 * https://mage2.pro/t/3445
	 * @used-by t01_success()
	 * @return array(string => string)
	 */
	private function customer() {return [
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
		,'country' => 'NL'
		,'email_address' => 'admin@mage2.pro'
		,'first_name' => 'Dmitry'
		,'forwarded_ip' => '5.9.188.84'
		// "male", "female", "other", null
		,'gender' => 'male'
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
}