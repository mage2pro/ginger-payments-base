<?php
namespace Df\GingerPaymentsBase\Source;
use GingerPayments\Payment\Order\Transaction\PaymentMethod as M;
/**
 * 2017-03-01
 * [Ginger Payments] Available payment options: https://mage2.pro/t/3463
 * [Kassa Compleet] Available payment options: https://mage2.pro/t/3248
 * @see \Dfe\GingerPayments\Source\Option
 * @see \Dfe\KassaCompleet\Source\Option
 * @method static Option s()
 */
abstract class Option extends \Df\Config\SourceT {
	/**
	 * 2017-03-01
	 * @used-by map()
	 * @see \Dfe\GingerPayments\Source\Option::mapExtra()
	 * @see \Dfe\KassaCompleet\Source\Option::mapExtra()
	 * @return array(string => string)
	 */
	abstract protected function mapExtra();

	/**
	 * 2017-03-04
	 * @used-by \Df\GingerPaymentsBase\Settings::options()
	 * @return array(string => string)
	 */
	final function optionsTest() {return $this->options(array_keys($this->mapTest()));}

	/**
	 * 2017-03-01
	 * 2017-03-02
	 * @todo Filter options by their availability to the concrete merchant:
	 * [Kassa Compleet] How to programmatically get the list of available payment options
	 * for a merchant? https://mage2.pro/t/3486
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()
	 * @return array(string => string)
	 */
	final protected function map() {return [
		// 2017-03-01
		// What is Bancontact? https://mage2.pro/t/3395
		// 2017-03-03
		// Whether Kassa Compleet allows to accept payments via Bancontact?
		// https://mage2.pro/t/3493
		M::BANCONTACT => 'Bancontact', M::BANK_CARD => 'Bank Card'
	] + $this->mapTest() + $this->mapExtra();}

	/**
	 * 2017-03-04
	 * [Ginger Payments] Which payment options are available in the test mode? https://mage2.pro/t/3492
	 * [Kassa Compleet] Which payment options are available in the test mode? https://mage2.pro/t/3272
	 * @used-by map()
	 * @used-by optionsTest()
	 * @return array(string => string)
	 */
	private function mapTest() {return [M::IDEAL => 'iDEAL', self::BANK_TRANSFER => 'Bank Transfer'];}

	/**
	 * 2017-03-01
	 * @used-by map()
	 * @see \GingerPayments\Payment\Order\Transaction\PaymentMethod::BANK_TRANSFER_ING
	 * @see \GingerPayments\Payment\Order\Transaction\PaymentMethod::BANK_TRANSFER_GINGER
	 */
	const BANK_TRANSFER = 'bank-transfer';
}