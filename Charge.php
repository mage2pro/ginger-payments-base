<?php
namespace Df\GingerPaymentsBase;
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
	 * @used-by \Df\PaypalClone\Method::getConfigPaymentAction()
	 * @param Method $m
	 * @return array(string, array(string => mixed))
	 */
	static function p(Method $m) {return (new self([self::$P__METHOD => $m]))->pCharge();}
}