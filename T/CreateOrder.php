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
	 */
	final function t01_success() {
		$this->api()->createOrder(
			// 2017-02-27
			// The amount in cents
			2500
			// 2017-02-27
			// The currency
			,'EUR'
			// 2017-02-27
			// The payment method
			,$this->method()
			// 2017-02-27
			// Extra details required for this payment method
			,$this->params()
			// 2017-02-27
			// A description (optional)
			// 2017-02-27
			,'A great order'
			// 2017-02-27
			// Your identifier for the order (optional)
			,'order-234192'
			// 2017-02-27
			// The return URL (optional)
			,'http://www.example.com'
			// 2017-02-27
			// The expiration period in ISO 8601 format (optional)
			,'PT15M'
		);
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