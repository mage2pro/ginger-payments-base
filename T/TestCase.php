<?php
namespace Df\GingerPaymentsBase\T;
use Df\GingerPaymentsBase\Settings as S;
use GingerPayments\Payment\Client as API;
// 2017-02-25
/** @method S s() */
abstract class TestCase extends \Df\Core\TestCase {
	/**
	 * 2017-02-26
	 * @return API
	 */
	final protected function api() {return $this->s()->api();}
}