<?php
namespace Dfe\GingerPaymentsBase;
use Dfe\GingerPaymentsBase\Charge as C;
use Dfe\GingerPaymentsBase\Source\Option as SO;
/**
 * 2017-04-17
 * @method \Dfe\GingerPaymentsBase\Method m()
 * @method \Dfe\GingerPaymentsBase\Settings s($k = null)
 */
final class Choice extends \Df\Payment\Choice {
	/**
	 * 2017-04-17
	 * @override
	 * @see \Df\Payment\Choice::title()
	 * @used-by \Df\Payment\Block\Info::choiceT()
	 * @used-by \Df\Payment\Observer\DataProvider\SearchResult::execute()
	 */
	function title():string {return dftr($this->optionCodeI(), $this->s()->os()->map());}

	/**
	 * 2017-03-29
	 * @used-by \Dfe\GingerPaymentsBase\Block\Info::bt()
	 */
	function bt():bool {return SO::BT === $this->optionCodeI();}

	/**
	 * 2017-03-29
	 * @used-by self::optionCode()
	 * @used-by self::prepareCommon()
	 * @return array(string => string|array)
	 */
	private function option():array {return dfc($this, function():array {return $this->psTransaction($this->req());});}

	/**
	 * 2017-03-29
	 * @used-by self::bt()
	 * @used-by self::title()
	 */
	private function optionCodeI():string {return dfc($this, function():string {return $this->m()->optionI(
		$this->option()[C::K_PAYMENT_METHOD]
	);});}

	/**
	 * 2017-03-29
	 * @used-by self::option()
	 * @used-by self::res0()
	 * @param array(string => mixed) $data
	 * @return array(string => mixed)
	 */
	private function psTransaction(array $data):array {return df_first($data[C::K_TRANSACTIONS]);}
}