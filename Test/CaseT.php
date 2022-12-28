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
	 * @used-by \Df\GingerPaymentsBase\Test\CreateOrder::t01_success()
	 */
	final protected function api():Api {return $this->m()->api();}
}