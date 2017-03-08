<?php
namespace Df\GingerPaymentsBase\T;
use Df\GingerPaymentsBase\Api;
use Df\GingerPaymentsBase\Method as M;
use Df\GingerPaymentsBase\Settings as S;
/**
 * 2017-02-25
 * @see \Df\GingerPaymentsBase\T\СreateOrder
 * @see \Df\GingerPaymentsBase\T\GetIdealBanks
 * @see \Df\GingerPaymentsBase\T\GetMerchant
 * @method M m()
 * @method S s()
 */
abstract class TestCase extends \Df\Payment\TestCase {
	/**
	 * 2017-02-26
	 * @param object|string|null $m [optional]
	 * @return Api
	 */
	final protected function api($m = null) {return $this->m()->api();}
}