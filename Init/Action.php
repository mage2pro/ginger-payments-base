<?php
namespace Df\GingerPaymentsBase\Init;
use Df\GingerPaymentsBase\Charge;
use Df\GingerPaymentsBase\Method as M;
use Df\Payment\W\Event as Ev;
// 2017-03-22
/** @method \Df\GingerPaymentsBase\Method m() */
final class Action extends \Df\Payment\Init\Action {
	/**
	 * 2017-03-22
	 * @override
	 * @see \Df\Payment\Init\Action::redirectUrl()
	 * @used-by \Df\Payment\Init\Action::action()
	 * @return string
	 */
	protected function redirectUrl() {return dfa($this->res()['transactions'][0], 'payment_url');}

	/**
	 * 2017-03-22
	 * 2017-03-09 Строка типа «95b5bacf-1686-4295-9706-55282af64a80».
	 * @override
	 * @see \Df\Payment\Init\Action::transId()
	 * @used-by \Df\Payment\Init\Action::action()
	 * @used-by action()
	 * @return string|null
	 */
	protected function transId() {return $this->e2i($this->res()['id'], Ev::T_INIT);}

	/**
	 * 2017-03-22
	 * @used-by res()
	 * @return array(string => mixed)
	 */
	private function req() {return dfc($this, function() {
		/** @var M $m */ /** @var array(string => mixed) $result */
		df_sentry_extra($m = $this->m(), 'Request Params', $result = Charge::p($m));
		$m->iiaSetTRR($result);
		return $result;
	});}

	/**
	 * 2017-03-22
	 * @used-by redirectUrl()
	 * @used-by transId()
	 * @return array(string => mixed)
	 */
	private function res() {return dfc($this, function() {
		$m = $this->m(); /** @var M $m */
		$m->iiaSetTRR(null, $r = $m->api()->orderPost($this->req())); /** @var array(string => mixed) $r */
		dfp_report($m, $r, 'response');
		return $r;
	});}
}