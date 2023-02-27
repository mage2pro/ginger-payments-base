<?php
namespace Dfe\GingerPaymentsBase\Test;
/**
 * 2017-03-01
 * @see \Dfe\GingerPayments\Test\GetMerchant
 * @see \Dfe\KassaCompleet\Test\GetMerchant
 */
abstract class GetMerchant extends CaseT {
	/**
	 * 2017-03-01
	 * 1) https://www.gingerpayments.com/docs#_merchants
	 * [Ginger Payments] Why does a «GET merchants/self/projects/self/» request
	 * lead to the «You don't have the permission to access the requested resource» response?
	 * https://mage2.pro/t/3457
	 * [Ginger Payments] Why does a «GET /merchants/{merchant_id}/projects/{project_id}/» request
	 * lead to the «You don't have the permission to access the requested resource» response?
	 * https://mage2.pro/t/3460
	 * 2) [Kassa Compleet] The «merchants/» API part is undocumented: https://mage2.pro/t/3459
	 * [Kassa Compleet] An example of a response to «GET merchants/self/projects/self/»
	 * https://mage2.pro/t/3458
	 * @test
	 */
	final function t01():void {
		print_r($this->api()->products($this->merchantId(), $this->projectId()));
		print_r($this->api()->lastResponse());
	}

	/**
	 * 2017-03-01
	 * @used-by self::t01()
	 * @see \Dfe\GingerPayments\Test\GetMerchant::merchantId()
	 */
	protected function merchantId():string {return 'self';}

	/**
	 * 2017-03-01
	 * @used-by self::t01()
	 * @see \Dfe\GingerPayments\Test\GetMerchant::projectId()
	 */
	protected function projectId():string {return 'self';}
}