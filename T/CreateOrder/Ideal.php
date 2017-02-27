<?php
namespace Df\GingerPaymentsBase\T\CreateOrder;
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
	final protected function method() {return 'ideal';}

	/**
	 * 2017-02-27
	 * @override
	 * @see \Df\GingerPaymentsBase\T\CreateOrder::params()
	 * @used-by \Df\GingerPaymentsBase\T\CreateOrder::t01_success()
	 * @return string
	 */
	final protected function params() {return ['issuer_id' => 'INGBNL2A'];}
}