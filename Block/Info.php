<?php
namespace Df\GingerPaymentsBase\Block;
use Df\GingerPaymentsBase\Charge as C;
/**
 * 2017-03-09
 * @final Unable to use the PHP «final» keyword here because of the M2 code generation.
 * @method \Df\GingerPaymentsBase\Method m()
 * @method \Df\GingerPaymentsBase\Settings s()
 */
class Info extends \Df\Payment\Block\Info {
	/**
	 * 2017-03-29
	 * @override
	 * @see \Df\Payment\Block\Info::checkoutSuccessHtml()
	 * @used-by \Df\Payment\Block\Info::_toHtml()
	 * @return string|null
	 */
	final protected function checkoutSuccessHtml() {return
		!$this->isBankTransfer() ? null : $this->bankTransferInstructions()
	;}

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
	 * 2017-03-29
	 * @used-by checkoutSuccessHtml()
	 * @return string
	 */
	private function bankTransferInstructions() {
		/** @var array(string => mixed) $res0 */
		$res0 = $this->psTransaction($this->tm()->res0());
		$this->psDetails($res0, 'reference');
		return df_tag('div', 'dfp-instructions', $this->psDetails($res0, 'reference'));
	}		

	/**
	 * 2017-03-29
	 * @used-by checkoutSuccessHtml()
	 * @return bool
	 */
	private function isBankTransfer() {return $this->s()->bankTransferId() === $this->optionCode();}

	/**
	 * 2017-03-29
	 * @used-by optionCode()
	 * @used-by siOption()
	 * @return array(string => string|array)
	 */
	private function option() {return dfc($this, function() {return $this->psTransaction(
		$this->tm()->req()
	);});}

	/**
	 * 2017-03-29
	 * @used-by isBankTransfer()
	 * @used-by siOption()
	 * @return array(string => string|array)
	 */
	private function optionCode() {return $this->option()[C::K_PAYMENT_METHOD];}

	/**
	 * 2017-03-29
	 * @used-by bankTransferInstructions()
	 * @used-by siOption()
	 * @param array(string => mixed) $trans
	 * @param string $k
	 * @return string|null
	 */
	private function psDetails(array $trans, $k) {return dfa_deep($trans, [
		C::K_PAYMENT_METHOD_DETAILS, $k
	]);}

	/**
	 * 2017-03-29
	 * @used-by bankTransferInstructions()
	 * @used-by option()
	 * @param array(string => mixed) $data
	 * @return array(string => mixed)
	 */
	private function psTransaction(array $data) {return df_first($data[C::K_TRANSACTIONS]);}

	/**
	 * 2017-03-28
	 * @used-by prepare()
	 * @used-by prepareUnconfirmed()
	 */
	private function siOption() {
		/** @var array(string => string|array) $o */
		$o = $this->option();
		$this->si('Payment Option', dftr($this->optionCode(), $this->s()->os()->map()));
		/** @var array(string => mixed)|null $d */
		if ($bank = $this->psDetails($o, C::K_ISSUER_ID)) {
			$this->si('Bank', dftr($bank, $this->m()->api()->idealBanks()));
		}
	}
}