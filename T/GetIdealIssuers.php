<?php
namespace Df\GingerPaymentsBase\T;
/**
 * 2017-02-27
 * @see \Dfe\GingerPayments\T\GetIdealIssuers
 * @see \Dfe\KassaCompleet\T\GetIdealIssuers
 */
abstract class GetIdealIssuers extends TestCase {
	/**
	 * @test
	 * 2017-02-27
	 */
	final function t01() {
		$this->api()->getIdealIssuers();
		echo $this->api()->lastResponse();
	}
}