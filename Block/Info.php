<?php
namespace Df\GingerPaymentsBase\Block;
use Df\GingerPaymentsBase\Charge as C;
/**
 * 2017-03-09
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * @method \Df\GingerPaymentsBase\Method m()
 * @method \Df\GingerPaymentsBase\Settings s($k = null)
 */
class Info extends \Df\Payment\Block\Info {
	/**
	 * 2017-03-29
	 * @override
	 * @see \Df\Payment\Block\Info::msgCheckoutSuccess()
	 * @used-by \Df\Payment\Block\Info::_toHtml()
	 * @return string|null
	 */
	final protected function msgCheckoutSuccess() {return !$this->bt() ? null : $this->btInstructions();}

	/**
	 * 2017-03-29
	 * @override
	 * @see \Df\Payment\Block\Info::msgUnconfirmed()
	 * @used-by \Df\Payment\Block\Info::rUnconfirmed()
	 * @return string|null
	 */
	final protected function msgUnconfirmed() {return
		df_is_backend() || !$this->bt() ? parent::msgUnconfirmed() : $this->btInstructions()
	;}

	/**
	 * 2017-03-09
	 * @override
	 * @see \Df\Payment\Block\Info::prepare()
	 * @used-by \Df\Payment\Block\Info::_prepareSpecificInformation()
	 */
	final protected function prepare() {$this->prepareCommon();}

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
	final protected function prepareUnconfirmed() {$this->prepareCommon();}

	/**
	 * 2017-03-29
	 * @used-by prepare()
	 * @used-by msgCheckoutSuccess()
	 * @used-by msgUnconfirmed()
	 * @return bool
	 */
	private function bt() {return $this->s()->btId() === $this->optionCode();}

	/**
	 * 2017-03-29
	 * @used-by msgCheckoutSuccess()
	 * @used-by msgUnconfirmed()
	 * @return string
	 */
	private function btInstructions() {return df_tag('div', 'dfp-instructions', df_var(
		$this->s('btInstructions'), [
			'amount' => $this->ii()->getOrder()->formatPrice($this->m()->amountParse(
				$this->tm()->req(C::K_AMOUNT)
			))
			,'reference' => $this->btReference()
		]
	));}

	/**
	 * 2017-03-29 A string like «0210201701122323».
	 * @used-by btInstructions()
	 * @used-by prepare()
	 * @return string
	 */
	private function btReference() {return $this->psDetails($this->res0(), 'reference');}

	/**
	 * 2017-03-29
	 * @used-by optionCode()
	 * @used-by prepareCommon()
	 * @return array(string => string|array)
	 */
	private function option() {return dfc($this, function() {return $this->psTransaction(
		$this->tm()->req()
	);});}

	/**
	 * 2017-03-29
	 * @used-by bt()
	 * @used-by prepareCommon()
	 * @return array(string => string|array)
	 */
	private function optionCode() {return $this->m()->optionI($this->option()[C::K_PAYMENT_METHOD]);}

	/**
	 * 2017-03-28
	 * @used-by prepare()
	 * @used-by prepareUnconfirmed()
	 */	
	private function prepareCommon() {
		$this->siID();
		/** @var array(string => string|array) $o */
		$o = $this->option();
		$this->si('Payment Option', dftr($this->optionCode(), $this->s()->os()->map()));
		// 2017-03-29 iDEAL
		/** @var string|null $bank */
		if ($bank = $this->psDetails($o, C::K_ISSUER_ID)) {
			$this->si('Bank', dftr($bank, $this->m()->api()->idealBanks()));
		}
		// 2017-03-29 Bank Transfer
		else if ($this->bt()) {
			$this->siEx('Bank Transfer Reference', $this->btReference());
		}
	}

	/**
	 * 2017-03-29
	 * @used-by btReference()
	 * @used-by prepareCommon()
	 * @param array(string => mixed) $trans
	 * @param string $k
	 * @return string|null
	 */
	private function psDetails(array $trans, $k) {return dfa_deep($trans, [
		C::K_PAYMENT_METHOD_DETAILS, $k
	]);}

	/**
	 * 2017-03-29
	 * @used-by option()
	 * @used-by res0()
	 * @param array(string => mixed) $data
	 * @return array(string => mixed)
	 */
	private function psTransaction(array $data) {return df_first($data[C::K_TRANSACTIONS]);}

	/**
	 * 2017-03-29
	 * @used-by btReference()
	 * @return array(string => mixed)
	 */
	private function res0() {return dfc($this, function() {return $this->psTransaction(
		$this->tm()->res0())
	;});}
}