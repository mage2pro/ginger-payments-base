<?php
namespace Df\GingerPaymentsBase;
/**
 * 2017-02-25
 * @see \Dfe\GingerPayments\Method
 * @see \Dfe\KassaCompleet\Method
 */
abstract class Method extends \Df\PaypalClone\Method\Normal {
	/**
	 * 2017-02-28
	 * Kassa Compleet and Ginger Payments use different formats
	 * for the «order_lines/order_line/vat_percentage» property
	 * of a «POST /v1/orders/» request: https://mage2.pro/t/3451
	 * @used-by \Df\GingerPaymentsBase\T\CreateOrder::t01_success()
	 * @see \Dfe\GingerPayments\Method::vatFactor()
	 * @see \Dfe\KassaCompleet\Method::vatFactor()
	 * @see \Df\Payment\Method::amountFactor()
	 * @return int
	 */
	abstract function vatFactor();

	/**
	 * 2017-02-25
	 * Первый параметр — для test, второй — для live.
	 * @override
	 * @see \Df\PaypalClone\Method\Normal::stageNames()
	 * @used-by \Df\PaypalClone\Method\Normal::url()
	 * @used-by \Df\PaypalClone\Refund::stageNames()
	 * @return string[]
	 */
	final function stageNames() {return ['', ''];}

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
	 * 2017-03-02
	 * @override
	 * @see \Df\Payment\Method::iiaKeys()
	 * @used-by \Df\Payment\Method::assignData()
	 * @return string[]
	 */
	final protected function iiaKeys() {return [self::$II_OPTION];}

	/**
	 * 2017-02-25
	 * Does Kassa Compleet use browser redirects? https://mage2.pro/t/3347
	 * Ginger Payments and Kassa Compleet use the same API: https://mage2.pro/t/3355
	 * @override
	 * @see \Df\PaypalClone\Method\Normal::redirectUrl()
	 * @used-by \Df\PaypalClone\Method\Normal::getConfigPaymentAction()
	 * @return string
	 */
	final protected function redirectUrl() {return '';}

	/**
	 * 2017-03-02
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.0.6/view/frontend/web/main.js?ts=4#L34
	 * @used-by iiaKeys()
	 * 2017-03-03
	 * If the iDEAL payment option is selected,
	 * then a value passed from a browser should include the chosen iDEAL issuer bank.
	 */
	private static $II_OPTION = 'option';
}