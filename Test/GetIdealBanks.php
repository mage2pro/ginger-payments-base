<?php
namespace Df\GingerPaymentsBase\Test;
/**
 * 2017-02-27
 * @see \Dfe\GingerPayments\Test\GetIdealBanks
 * @see \Dfe\KassaCompleet\T\GetIdealBanks
 */
abstract class GetIdealBanks extends CaseT {
	/**
	 * @test
	 * 2017-02-27
	 */
	final function t01() {
		print_r($this->api()->idealBanks());
		print_r($this->api()->lastResponse());
	}
}