<?php
namespace Df\GingerPaymentsBase;
use GingerPayments\Payment\Client as API;
/**
 * 2017-02-25
 * @see \Dfe\GingerPayments\Method
 * @see \Dfe\KassaCompleet\Method
 */
abstract class Method extends \Df\PaypalClone\Method {
	/**
	 * 2017-02-28
	 * Kassa Compleet and Ginger Payments use different formats
	 * for the «order_lines/order_line/vat_percentage» property
	 * of a «POST /v1/orders/» request: https://mage2.pro/t/3451
	 * @used-by \Df\GingerPaymentsBase\Charge::pOrderLines_products()
	 * @used-by \Df\GingerPaymentsBase\T\CreateOrder::t01_success()
	 * @see \Dfe\GingerPayments\Method::vatIsInteger()
	 * @see \Dfe\KassaCompleet\Method::vatIsInteger()
	 * @see \Df\Payment\Method::amountFactor()
	 * @return int
	 */
	abstract function vatIsInteger();

	/**
	 * 2017-02-25
	 * @override
	 * @todo
	 * @see \Df\Payment\Method::amountLimits()
	 * @used-by \Df\Payment\Method::isAvailable()
	 * @return null
	 */
	final protected function amountLimits() {return null;}

	/**
	 * 2017-03-05
	 * Сюда мы попадаем только из метода @used-by \Magento\Sales\Model\Order\Payment::place()
	 * причём там наш метод вызывается сразу из двух мест и по-разному.
	 * Умышленно возвращаем null.
	 * @used-by \Magento\Sales\Model\Order\Payment::place()
	 * https://github.com/magento/magento2/blob/2.1.5/app/code/Magento/Sales/Model/Order/Payment.php#L334-L355
	 * @override
	 * @see \Df\Payment\Method::getConfigPaymentAction()
	 * @return string
	 */
	final function getConfigPaymentAction() {return null;}

	/**
	 * 2017-03-02
	 * @override
	 * @see \Df\Payment\Method::iiaKeys()
	 * @used-by \Df\Payment\Method::assignData()
	 * @return string[]
	 */
	final protected function iiaKeys() {return [self::$II_BANK, self::$II_OPTION];}

	/**
	 * 2017-03-06
	 * @return API
	 */
	private function api() {return $this->s()->api();}

	/**
	 * 2017-03-05
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.2.2/view/frontend/web/main.js?ts=4#L25
	 * @used-by iiaKeys()
	 */
	private static $II_BANK = 'bank';

	/**
	 * 2017-03-05
	 * https://github.com/mage2pro/core/blob/2.0.36/Payment/view/frontend/web/withOptions.js?ts=4#L23
	 * @used-by iiaKeys()
	 */
	private static $II_OPTION = 'option';
}