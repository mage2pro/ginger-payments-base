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
	 * 2017-03-01
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()
	 * @return array(string => string)
	 */
	final protected function map() {return [
		M::BANK_CARD => 'Bank Card'
		,self::BANK_TRANSFER => 'Bank Transfer'
		,M::IDEAL => 'iDEAL'
	] + $this->mapExtra();}

	/**
	 * 2017-03-01
	 * @used-by map()
	 * @see \GingerPayments\Payment\Order\Transaction\PaymentMethod::BANK_TRANSFER_ING
	 * @see \GingerPayments\Payment\Order\Transaction\PaymentMethod::BANK_TRANSFER_GINGER
	 */
	const BANK_TRANSFER = 'bank-transfer';
}