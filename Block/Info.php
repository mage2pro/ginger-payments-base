<?php
namespace Df\GingerPaymentsBase\Block;
use Df\GingerPaymentsBase\Charge as C;
/**
 * 2017-03-09
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * @method \Df\GingerPaymentsBase\Settings s()
 */
class Info extends \Df\Payment\Block\Info {
	/**
	 * 2017-03-09
	 * @override
	 * @see \Df\Payment\Block\Info::prepare()
	 * @used-by \Df\Payment\Block\Info::_prepareSpecificInformation()
	 */
	final protected function prepare() {$this->siOption();}

	/**
	 * 2017-03-28
	 * ПС работает с перенаправлением покупателя на свою страницу.
	 * Покупатель был туда перенаправлен, однако ПС ещё не прислала оповещение о платеже
	 * (и способе оплаты). Т.е. покупатель ещё ничего не оплатил,
	 * и, возможно, просто закрыл страницу оплаты и уже ничего не оплатит.
	 * @override
	 * @see \Df\Payment\Block\Info::prepareUnconfirmed()
	 * @used-by \Df\Payment\Block\Info::_prepareSpecificInformation()
	 */
	final protected function prepareUnconfirmed() {$this->siOption();}

	/**
	 * 2017-03-28
	 * @used-by prepare()
	 * @used-by prepareUnconfirmed()
	 */
	private function siOption() {
		/** @var array(string => string|array) $o */
		$o = df_first(df_tm($this->m())->req(C::K_TRANSACTIONS));
		$this->si('Payment Option', dftr($o[C::K_PAYMENT_METHOD], $this->s()->os()->map()));
		/** @var array(string => mixed)|null $d */
		if ($bank = dfa_deep($o, [C::K_PAYMENT_METHOD_DETAILS, C::K_ISSUER_ID])) {
			$this->si('Bank', $bank);
		}
	}
}