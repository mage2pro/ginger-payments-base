<?php
namespace Df\GingerPaymentsBase\Test;
/**
 * 2017-02-27
 * @see \Dfe\GingerPayments\Test\GetIdealBanks
 * @see \Dfe\KassaCompleet\Test\GetIdealBanks
 */
abstract class GetIdealBanks extends CaseT {
	/** 2017-02-27 @test */
	final function t01():void {
		print_r($this->api()->idealBanks());
		print_r($this->api()->lastResponse());
	}
}