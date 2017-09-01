<?php
namespace Df\GingerPaymentsBase;
use Df\GingerPaymentsBase\Charge as C;
use Df\GingerPaymentsBase\Source\Option as SO;
use Magento\Framework\Phrase;
/**
 * 2017-04-17
 * @method \Df\GingerPaymentsBase\Method m()
 * @method \Df\GingerPaymentsBase\Settings s($k = null)
 */
final class Choice extends \Df\Payment\Choice {
	/**
	 * 2017-04-17
	 * @override
	 * @see \Df\Payment\Choice::title()
	 * @used-by \Df\Payment\Block\Info::choiceT()
	 * @used-by \Df\Payment\Observer\DataProvider\SearchResult::execute()
	 * @return Phrase|string|null
	 */
	function title() {return dftr($this->optionCodeI(), $this->s()->os()->map());}

	/**
	 * 2017-03-29
	 * @used-by \Df\GingerPaymentsBase\Block\Info::bt()
	 * @return bool
	 */
	function bt() {return SO::BT === $this->optionCodeI();}

	/**
	 * 2017-03-29
	 * @used-by optionCode()
	 * @used-by prepareCommon()
	 * @return array(string => string|array)
	 */
	private function option() {return dfc($this, function() {return $this->psTransaction($this->req());});}

	/**
	 * 2017-03-29
	 * @used-by bt()
	 * @used-by prepareCommon()
	 * @return array(string => string|array)
	 */
	private function optionCodeI() {return dfc($this, function() {return $this->m()->optionI(
		$this->option()[C::K_PAYMENT_METHOD]
	);});}

	/**
	 * 2017-03-29
	 * @used-by option()
	 * @used-by res0()
	 * @param array(string => mixed) $data
	 * @return array(string => mixed)
	 */
	private function psTransaction(array $data) {return df_first($data[C::K_TRANSACTIONS]);}
}