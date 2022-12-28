<?php
namespace Df\GingerPaymentsBase\Test;
use Df\GingerPaymentsBase\Api;
use Df\GingerPaymentsBase\Method as M;
use Df\GingerPaymentsBase\Settings as S;
/**
 * 2017-02-25
 * @see \Df\GingerPaymentsBase\Test\СreateOrder
 * @see \Df\GingerPaymentsBase\Test\GetIdealBanks
 * @see \Df\GingerPaymentsBase\Test\GetMerchant
 * @method M m()
 * @method S s()
 */
abstract class CaseT extends \Df\Payment\TestCase {
	/**
	 * 2017-02-26
	 * @param object|string|null $m [optional]
	 * @return Api
	 */
	final protected function api($m = null):Api {return $this->m()->api();}
}