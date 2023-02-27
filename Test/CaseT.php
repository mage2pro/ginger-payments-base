<?php
namespace Dfe\GingerPaymentsBase\Test;
use Dfe\GingerPaymentsBase\Api;
use Dfe\GingerPaymentsBase\Method as M;
use Dfe\GingerPaymentsBase\Settings as S;
/**
 * 2017-02-25
 * @see \Dfe\GingerPaymentsBase\Test\СreateOrder
 * @see \Dfe\GingerPaymentsBase\Test\GetIdealBanks
 * @see \Dfe\GingerPaymentsBase\Test\GetMerchant
 * @method M m()
 * @method S s()
 */
abstract class CaseT extends \Df\Payment\TestCase {
	/**
	 * 2017-02-26
	 * @used-by \Dfe\GingerPaymentsBase\Test\CreateOrder::t01_success()
	 * @used-by \Dfe\GingerPaymentsBase\Test\GetIdealBanks::t01()
	 * @used-by \Dfe\GingerPaymentsBase\Test\GetMerchant::t01()
	 */
	final protected function api():Api {return $this->m()->api();}
}