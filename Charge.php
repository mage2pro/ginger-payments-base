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
	private function pCharge() {return [];}

	/**
	 * 2017-03-06
	 * @used-by \Df\PaypalClone\Method::getConfigPaymentAction()
	 * @param Method $m
	 * @return array(string, array(string => mixed))
	 */
	static function p(Method $m) {return (new self([self::$P__METHOD => $m]))->pCharge();}
}