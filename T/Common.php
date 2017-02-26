<?php
// 2017-02-25
namespace Df\GingerPaymentsBase\T;
use Dfe\GingerPayments\Settings as GS;
use Dfe\KassaCompleet\Settings as KS;
final class Common extends TestCase {
	/** 2017-02-25 */
	function t00() {}

	/** 2017-02-25 */
	function t01() {print_r([
		KS::s()->privateKey()
		,GS::s()->privateKey()
		,get_class($this->apiK())
		,get_class($this->apiG())
	]);}

	/** 2017-02-26 */
	function t02() {
		$order = $this->apiK()->createOrder(
			2500,                           // The amount in cents
			'EUR',                          // The currency
			'ideal',                        // The payment method
			['issuer_id' => 'INGBNL2A'],    // Extra details required for this payment method
			'A great order',                // A description (optional)
			'order-234192',                 // Your identifier for the order (optional)
			'http://www.example.com',       // The return URL (optional)
			'PT15M'                         // The expiration period in ISO 8601 format (optional)
		);
		echo $this->apiK()->lastResponse();
	}

	/** @test 2017-02-26 */
	function t03() {
		$order = $this->apiG()->createOrder(
			2500,                           // The amount in cents
			'EUR',                          // The currency
			'ideal',                        // The payment method
			['issuer_id' => 'INGBNL2A'],    // Extra details required for this payment method
			'A great order',                // A description (optional)
			'order-234192',                 // Your identifier for the order (optional)
			'http://www.example.com',       // The return URL (optional)
			'PT15M'                         // The expiration period in ISO 8601 format (optional)
		);
		echo $this->apiG()->lastResponse();
	}
}