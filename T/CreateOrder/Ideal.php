<?php
namespace Df\GingerPaymentsBase\T\CreateOrder;
use GingerPayments\Payment\Order\Transaction\PaymentMethod as M;
/**
 * 2017-02-27
 * @see \Dfe\GingerPayments\T\CreateOrder\Ideal
 * @see \Dfe\KassaCompleet\T\CreateOrder\Ideal
 */
abstract class Ideal extends \Df\GingerPaymentsBase\T\CreateOrder {
	/**
	 * 2017-02-27
	 * @override
	 * @see \Df\GingerPaymentsBase\T\CreateOrder::method()
	 * @used-by \Df\GingerPaymentsBase\T\CreateOrder::t01_success()
	 * @return string
	 */
	final protected function method() {return M::IDEAL;}

	/**
	 * 2017-02-27
	 * @override
	 * @see \Df\GingerPaymentsBase\T\CreateOrder::params()
	 * @used-by \Df\GingerPaymentsBase\T\CreateOrder::t01_success()
	 * @return string
	 */
	final protected function params() {return [
		// 2017-02-27
		// This parameter is required:
		// https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#creating-an-ideal-order
		// https://www.gingerpayments.com/docs#creating-an-ideal-order
		'issuer_id' => 'INGBNL2A'
	];}
}