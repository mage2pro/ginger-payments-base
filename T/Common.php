<?php
// 2017-02-25
namespace Df\GingerPaymentsBase\T;
use Dfe\KassaCompleet\Settings as S;
final class Common extends TestCase {
	/** 2017-02-25 */
	function t00() {}

	/** @test 2017-02-25 */
	function t01() {echo S::s()->privateKey();}
}