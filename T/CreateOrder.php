<?php
namespace Df\GingerPaymentsBase\T;
/**
 * 2017-02-27
 * @see \Dfe\GingerPayments\T\CreateOrder
 * @see \Dfe\KassaCompleet\T\CreateOrder
 */
abstract class CreateOrder extends TestCase {
	/**
	 * @test
	 * @final
	 * 2017-02-27
	 */
	function t01_ideal() {
		$this->api()->createOrder(
			2500,                           // The amount in cents
			'EUR',                          // The currency
			'ideal',                        // The payment method
			['issuer_id' => 'INGBNL2A'],    // Extra details required for this payment method
			'A great order',                // A description (optional)
			'order-234192',                 // Your identifier for the order (optional)
			'http://www.example.com',       // The return URL (optional)
			'PT15M'                         // The expiration period in ISO 8601 format (optional)
		);
		echo $this->api()->lastResponse();
	}
}