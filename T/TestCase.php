<?php
// 2017-02-25
namespace Df\GingerPaymentsBase\T;
use \GingerPayments\Payment\Ginger as API;
abstract class TestCase extends \Df\Core\TestCase {
	/**
	 * 2017-02-15
	 * @return API
	 */
	final protected function api() {return null;}
}