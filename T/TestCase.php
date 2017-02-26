<?php
namespace Df\GingerPaymentsBase\T;
use Df\GingerPaymentsBase\Settings as S;
use Dfe\GingerPayments\Settings as GS;
use Dfe\KassaCompleet\Settings as KS;
use GingerPayments\Payment\Client as API;
// 2017-02-25
/** @method S s() */
abstract class TestCase extends \Df\Core\TestCase {
	/**
	 * 2017-02-26
	 * @param object|string|null $m [optional]
	 * @return API
	 */
	final protected function api($m = null) {return $this->s($m)->api();}

	/**
	 * 2017-02-26
	 * @return API
	 */
	final protected function apiG() {return $this->api(GS::class);}

	/**
	 * 2017-02-26
	 * @return API
	 */
	final protected function apiK() {return $this->api(KS::class);}
}