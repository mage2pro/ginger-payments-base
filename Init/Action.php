<?php
namespace Df\GingerPaymentsBase\Init;
use Df\GingerPaymentsBase\Charge;
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
	protected function transId() {return $this->m()->e2i($this->res()['id']);}

	/**
	 * 2017-03-22
	 * @used-by res()
	 * @return array(string => mixed)
	 */
	private function req() {return dfc($this, function() {
		/** @var array(string => mixed) $result */
		df_sentry_extra($this->m(), 'Request Params', $result = Charge::p($this->m()));
		return $result;
	});}

	/**
	 * 2017-03-22
	 * 2used-by redirectUrl()
	 * @used-by transId()
	 * @return array(string => mixed)
	 */
	private function res() {return dfc($this, function() {
		/** @var array(string => mixed) $result */
		$result = $this->m()->api()->orderPost($this->req());
		if ($this->s()->log()) {
			dfp_report($this->m(), $result, 'response');
		}
		return $result;
	});}
}