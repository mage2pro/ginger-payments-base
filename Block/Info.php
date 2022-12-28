<?php
namespace Df\GingerPaymentsBase\Block;
use Df\GingerPaymentsBase\Charge as C;
/**
 * 2017-03-09
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * @method \Df\GingerPaymentsBase\Method m()
 * @method \Df\GingerPaymentsBase\Choice choice()
 * @method \Df\GingerPaymentsBase\Settings|string s($k = null)
 */
class Info extends \Df\Payment\Block\Info {
	/**
	 * 2017-03-29
	 * @override
	 * @see \Df\Payment\Block\Info::msgCheckoutSuccess()
	 * @used-by \Df\Payment\Block\Info::checkoutSuccess()
	 */
	final protected function msgCheckoutSuccess():string {return !$this->bt() ? '' : $this->btInstructions();}

	/**
	 * 2017-03-29
	 * @override
	 * @see \Df\Payment\Block\Info::msgUnconfirmed()
	 * @used-by \Df\Payment\Block\Info::rUnconfirmed()
	 */
	final protected function msgUnconfirmed():string {return
		df_is_backend() || !$this->bt() ? parent::msgUnconfirmed() : $this->btInstructions()
	;}

	/**
	 * 2017-03-09
	 * @override
	 * @see \Df\Payment\Block\Info::prepare()
	 * @used-by \Df\Payment\Block\Info::prepareToRendering()
	 */
	final protected function prepare():void {$this->prepareCommon();}

	/**
	 * 2017-03-28
	 * ПС работает с перенаправлением покупателя на свою страницу.
	 * Покупатель был туда перенаправлен, однако ПС ещё не прислала оповещение о платеже
	 * (и способе оплаты). Т.е. покупатель ещё ничего не оплатил,
	 * и, возможно, просто закрыл страницу оплаты и уже ничего не оплатит.
	 * @override
	 * @see \Df\Payment\Block\Info::prepareUnconfirmed()
	 * @used-by \Df\Payment\Block\Info::prepareToRendering()
	 */
	final protected function prepareUnconfirmed():void {$this->prepareCommon();}

	/**
	 * 2017-03-29
	 * @used-by self::prepare()
	 * @used-by self::msgCheckoutSuccess()
	 * @used-by self::msgUnconfirmed()
	 */
	function bt():bool {return $this->choice()->bt();}

	/**
	 * 2017-03-29
	 * @used-by self::msgCheckoutSuccess()
	 * @used-by self::msgUnconfirmed()
	 */
	private function btInstructions():string {return df_tag('div', 'dfp-instructions', df_var(
		$this->s('btInstructions'), [
			'amount' => $this->ii()->getOrder()->formatPrice($this->m()->amountParse($this->tm()->req(C::K_AMOUNT)))
			,'reference' => $this->btReference()
		]
	));}

	/**
	 * 2017-03-29 A string like «0210201701122323».
	 * @used-by self::btInstructions()
	 * @used-by self::prepare()
	 */
	private function btReference():string {return $this->psDetails($this->res0(), 'reference');}

	/**
	 * 2017-03-28
	 * @used-by self::prepare()
	 * @used-by self::prepareUnconfirmed()
	 */	
	private function prepareCommon():void {
		$this->siID();
		$this->si('Payment Option', $this->choiceT());
		# 2017-03-29 iDEAL
		/** @var string|null $bank */
		if ($bank = $this->psDetails($this->psTransaction($this->tm()->req()), C::K_ISSUER_ID)) {
			$this->si('Bank', dftr($bank, $this->m()->api()->idealBanks()));
		}
		# 2017-03-29 Bank Transfer
		elseif ($this->bt()) {
			$this->siEx('Bank Transfer Reference', $this->btReference());
		}
	}

	/**
	 * 2017-03-29
	 * @used-by self::btReference()
	 * @used-by self::prepareCommon()
	 * @param array(string => mixed) $trans
	 * @param string $k
	 * @return string|null
	 */
	private function psDetails(array $trans, string $k) {return dfa_deep($trans, [C::K_PAYMENT_METHOD_DETAILS, $k]);}

	/**
	 * 2017-03-29
	 * @used-by self::option()
	 * @used-by self::res0()
	 * @param array(string => mixed) $data
	 * @return array(string => mixed)
	 */
	private function psTransaction(array $data) {return df_first($data[C::K_TRANSACTIONS]);}

	/**
	 * 2017-03-29
	 * @used-by self::btReference()
	 * @return array(string => mixed)
	 */
	private function res0() {return dfc($this, function() {return $this->psTransaction($this->tm()->res0());});}
}