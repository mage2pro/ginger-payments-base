<?php
namespace Df\GingerPaymentsBase\T;
use Df\GingerPaymentsBase\Settings as S;
use GingerPayments\Payment\Client as API;
/**
 * 2017-02-25
 * @see \Df\GingerPaymentsBase\T\СreateOrder
 * @method S s()
 */
abstract class TestCase extends \Df\Core\TestCase {
	/**
	 * 2017-02-26
	 * @param object|string|null $m [optional]
	 * @return API
	 */
	final protected function api($m = null) {return $this->s($m)->api();}
}