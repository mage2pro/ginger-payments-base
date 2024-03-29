<?php
namespace Dfe\GingerPaymentsBase\Source;
/**
 * 2017-03-01
 * [Ginger Payments] Available payment options: https://mage2.pro/t/3463
 * [Kassa Compleet] Available payment options: https://mage2.pro/t/3248
 * @see \Dfe\GingerPayments\Source\Option
 * @see \Dfe\KassaCompleet\Source\Option
 * @method static Option s()
 */
abstract class Option extends \Df\Config\Source {
	/**
	 * 2017-03-01
	 * @used-by self::map()
	 * @see \Dfe\GingerPayments\Source\Option::mapExtra()
	 * @see \Dfe\KassaCompleet\Source\Option::mapExtra()
	 * @return array(string => string)
	 */
	abstract protected function mapExtra():array;

	/**
	 * 2017-03-04
	 * @used-by \Dfe\GingerPaymentsBase\Settings::options()
	 * @return array(<value> => <label>)
	 */
	final function optionsTest():array {return $this->options(array_keys($this->mapTest()));}

	/**
	 * 2017-03-01
	 * 2017-03-02
	 * @todo Filter options by their availability to the concrete merchant:
	 * [Kassa Compleet] How to programmatically get the list of available payment options
	 * for a merchant? https://mage2.pro/t/3486
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()
	 * @used-by \Dfe\GingerPaymentsBase\Block\Info::prepareCommon()
	 * @return array(string => string)
	 */
	final function map():array {return [
		# 2017-03-01 What is Bancontact? https://mage2.pro/t/3395
		# 2017-03-03 Whether Kassa Compleet allows to accept payments via Bancontact? https://mage2.pro/t/3493
		'bancontact' => 'Bancontact', 'credit-card' => 'Bank Card'
	] + $this->mapTest() + $this->mapExtra();}

	/**
	 * 2017-03-04
	 * [Ginger Payments] Which payment options are available in the test mode? https://mage2.pro/t/3492
	 * [Kassa Compleet] Which payment options are available in the test mode? https://mage2.pro/t/3272
	 * @used-by self::map()
	 * @used-by self::optionsTest()
	 * @return array(string => string)
	 */
	private function mapTest():array {return [self::IDEAL => 'iDEAL', self::BT => 'Bank Transfer'];}

	/**
	 * 2017-03-01
	 * @used-by self::map()
	 * @used-by \Dfe\GingerPaymentsBase\Block\Info::bt()
	 * @used-by \Dfe\GingerPaymentsBase\Method::optionI2E()
	 */
	const BT = 'bank-transfer';
	/**
	 * 2017-02-27
	 * @used-by self::map()
	 * @used-by \Dfe\GingerPaymentsBase\Charge::pTransactions()
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.2.5/view/frontend/web/main.js?ts=4#L82
	 */
	const IDEAL = 'ideal';
}