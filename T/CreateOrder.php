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
}