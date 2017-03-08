<?php
namespace Df\GingerPaymentsBase;
use Df\GingerPaymentsBase\Source\Option as SO;
use GingerPayments\Payment\Client as API;
use GingerPayments\Payment\Order\Transaction\PaymentMethod as GM;
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
	 * 2017-03-07
	 * @see \Dfe\GingerPayments\Method::bankTransferId()
	 * @see \Dfe\KassaCompleet\Method::bankTransferId()
	 * @used-by optionT()
	 * @return string
	 */
	abstract protected function bankTransferId();

	/**
	 * 2017-03-06
	 * @used-by \Df\GingerPaymentsBase\Charge::pCharge()
	 * @return string|null
	 */
	final function bank() {return $this->iia(self::$II_BANK);}

	/**
	 * 2017-03-06
	 * @used-by \Df\GingerPaymentsBase\Charge::pCharge()
	 * @return bool
	 */
	final function isIdeal() {return GM::IDEAL === $this->option();}

	/**
	 * 2017-03-07
	 * @used-by \Df\GingerPaymentsBase\Charge::pTransactions()
	 * @return string
	 */
	final function optionT() {return dftr($this->option(), [
		SO::BANK_TRANSFER => $this->bankTransferId()
	]);}

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
	final function getConfigPaymentAction() {
		/** @var array(string => mixed) $p */
		$p = Charge::p($this);
		df_sentry_extra($this, 'Request Params', $p);
		$this->api()->postOrder($p);
		/** @var string $responseJson */
		$responseJson = $this->api()->lastResponse();
		/** @var array(string => mixed) $responseA */
		$responseA = df_json_decode($responseJson);
		return null;
	}

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
	 * 2017-03-06
	 * @used-by isIdeal()
	 * @used-by optionT()
	 * @return string
	 */
	private function option() {return df_result_sne($this->iia(self::$II_OPTION));}

	/**
	 * 2017-03-05
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.2.2/view/frontend/web/main.js?ts=4#L25
	 * @used-by bank()
	 * @used-by iiaKeys()
	 */
	private static $II_BANK = 'bank';

	/**
	 * 2017-03-05
	 * https://github.com/mage2pro/core/blob/2.0.36/Payment/view/frontend/web/withOptions.js?ts=4#L23
	 * @used-by iiaKeys()
	 * @used-by option()
	 */
	private static $II_OPTION = 'option';
}