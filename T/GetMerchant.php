<?php
namespace Df\GingerPaymentsBase\T;
/**
 * 2017-03-01
 * @see \Dfe\GingerPayments\T\GetMerchant
 * @see \Dfe\KassaCompleet\T\GetMerchant
 */
abstract class GetMerchant extends TestCase {
	/**
	 * @test
	 * 2017-03-01
	 * https://www.gingerpayments.com/docs#_merchants
	 * [Ginger Payments] Why does a «GET merchants/self/projects/self/» request
	 * lead to the «You don't have the permission to access the requested resource» response?
	 * https://mage2.pro/t/3457
	 * [Ginger Payments] Why does a «GET /merchants/{merchant_id}/projects/{project_id}/» request
	 * lead to the «You don't have the permission to access the requested resource» response?
	 * https://mage2.pro/t/3460
	 *
	 * [Kassa Compleet] The «merchants/» API part is undocumented: https://mage2.pro/t/3459
	 * [Kassa Compleet] An example of a response to «GET merchants/self/projects/self/»
	 * https://mage2.pro/t/3458
	 */
	final function t01() {
		print_r($this->api()->products($this->merchantId(), $this->projectId()));
		echo $this->api()->lastResponse();
	}

	/**
	 * 2017-03-01
	 * @used-by t01()
	 * @see \Dfe\GingerPayments\T\GetMerchant::merchantId()
	 * @return string
	 */
	protected function merchantId() {return 'self';}

	/**
	 * 2017-03-01
	 * @used-by t01()
	 * @see \Dfe\GingerPayments\T\GetMerchant::projectId()
	 * @return string
	 */
	protected function projectId() {return 'self';}
}