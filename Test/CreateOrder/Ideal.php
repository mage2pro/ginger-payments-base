<?php
namespace Dfe\GingerPaymentsBase\Test\CreateOrder;
/**
 * 2017-02-27
 * @see \Dfe\GingerPayments\Test\CreateOrder\Ideal
 * @see \Dfe\KassaCompleet\Test\CreateOrder\Ideal
 */
abstract class Ideal extends \Dfe\GingerPaymentsBase\Test\CreateOrder {
	/**
	 * 2017-02-27
	 * @override
	 * @see \Dfe\GingerPaymentsBase\Test\CreateOrder::method()
	 * @used-by \Dfe\GingerPaymentsBase\Test\CreateOrder::t01_success()
	 */
	final protected function method():string {return 'ideal';}

	/**
	 * 2017-02-27
	 * @override
	 * @see \Dfe\GingerPaymentsBase\Test\CreateOrder::params()
	 * @used-by \Dfe\GingerPaymentsBase\Test\CreateOrder::t01_success()
	 */
	final protected function params():array {return [
		# 2017-02-27
		# This parameter is required:
		# https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#creating-an-ideal-order
		# https://www.gingerpayments.com/docs#creating-an-ideal-order
		'issuer_id' => 'INGBNL2A'
	];}
}