<?php
namespace Dfe\GingerPaymentsBase\Init;
use Dfe\GingerPaymentsBase\Charge;
use Dfe\GingerPaymentsBase\Method as M;
use Df\Payment\W\Event as Ev;
# 2017-03-22
/** @method \Dfe\GingerPaymentsBase\Method m() */
final class Action extends \Df\Payment\Init\Action {
	/**
	 * 2017-03-22
	 * @override
	 * @see \Df\Payment\Init\Action::redirectUrl()
	 * @used-by \Df\Payment\Init\Action::action()
	 */
	protected function redirectUrl():string {return dfa($this->res()['transactions'][0], 'payment_url');}

	/**
	 * 2017-03-22
	 * 2017-03-09 Строка типа «95b5bacf-1686-4295-9706-55282af64a80».
	 * @override
	 * @see \Df\Payment\Init\Action::transId()
	 * @used-by \Df\Payment\Init\Action::action()
	 * @used-by self::action()
	 */
	protected function transId():string {return $this->e2i($this->res()['id'], Ev::T_INIT);}

	/**
	 * 2017-03-22
	 * @used-by self::res()
	 * @return array(string => mixed)
	 */
	private function req():array {return dfc($this, function() {
		/** @var M $m */ /** @var array(string => mixed) $r */
		df_sentry_extra($m = $this->m(), 'Request Params', $r = Charge::p($m));
		$m->iiaSetTRR($r);
		return $r;
	});}

	/**
	 * 2017-03-22
	 * @used-by self::redirectUrl()
	 * @used-by self::transId()
	 * @return array(string => mixed)
	 */
	private function res():array {return dfc($this, function():array {
		$m = $this->m(); /** @var M $m */
		$m->iiaSetTRR(null, $r = $m->api()->orderPost($this->req())); /** @var array(string => mixed) $r */
		dfp_report($m, $r, 'response');
		return $r;
	});}
}