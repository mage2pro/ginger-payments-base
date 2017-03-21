<?php
namespace Df\GingerPaymentsBase;
use Df\GingerPaymentsBase\Source\Option as SO;
use Df\Payment\PlaceOrderInternal as PO;
use Magento\Sales\Model\Order\Payment\Transaction as T;
/**
 * 2017-02-25
 * @see \Dfe\GingerPayments\Method
 * @see \Dfe\KassaCompleet\Method
 */
abstract class Method extends \Df\PaypalClone\Method {
	/**
	 * 2017-03-06
	 * @used-by getConfigPaymentAction()
	 * @used-by \Df\GingerPaymentsBase\ConfigProvider::config()
	 * @used-by \Df\GingerPaymentsBase\T\TestCase::api()
	 * @return Api
	 */
	final function api() {return dfc($this, function() {return new Api($this);});}

	/**
	 * 2017-03-06
	 * @used-by \Df\GingerPaymentsBase\Charge::pCharge()
	 * @return string|null
	 */
	final function bank() {return $this->iia(self::$II_BANK);}

	/**
	 * 2017-03-07
	 * https://mage2.pro/t/3355/2
	 * 2017-03-08
	 * https://github.com/mage2pro/ginger-payments/blob/0.2.2/etc/config.xml?ts=4#L16
	 * https://github.com/mage2pro/kassa-compleet/blob/0.2.2/etc/config.xml?ts=4#L16
	 * @used-by \Df\GingerPaymentsBase\Charge::pTransactions()
	 * @return string
	 */
	final function optionT() {return dftr($this->option(), [SO::BT => $this->s('bankTransferId')]);}

	/**
	 * 2017-02-28
	 * Kassa Compleet and Ginger Payments use different formats
	 * for the «order_lines/order_line/vat_percentage» property
	 * of a «POST /v1/orders/» request: https://mage2.pro/t/3451
	 * @used-by \Df\GingerPaymentsBase\Charge::pOrderLines_products()
	 * @used-by \Df\GingerPaymentsBase\T\CreateOrder::t01_success()
	 * 2017-03-08
	 * https://github.com/mage2pro/ginger-payments/blob/0.2.3/etc/config.xml?ts=4#L23
	 * https://github.com/mage2pro/kassa-compleet/blob/0.2.3/etc/config.xml?ts=4#L23
	 * @return bool
	 */
	final function vatIsInteger() {return df_bool($this->s('vatIsInteger'));}

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
		/** @var array(string => mixed) $req */
		$req = Charge::p($this);
		df_sentry_extra($this, 'Request Params', $req);
		/** @var array(string => mixed) $res */
		$res = $this->api()->orderPost($req);
		if ($this->s()->log()) {
			dfp_report($this, $res, 'response');
		}
		if ($this->s()->log()) {
			// 2017-01-12
			// В локальный лог попадает только response, а в Sentry: и request, и response.
			dfp_report($this, $res, df_caller_ff(-1));
		}
		$this->iiaSetTRR($req, $res);
		PO::setData($this, dfa($res['transactions'][0], 'payment_url'));
		// 2016-05-06
		// Письмо-оповещение о заказе здесь ещё не должно отправляться.
		// «How is a confirmation email sent on an order placement?» https://mage2.pro/t/1542
		$this->o()->setCanSendNewEmailFlag(false);
		// 2017-03-09
		// Строка типа «95b5bacf-1686-4295-9706-55282af64a80».
		$this->ii()->setTransactionId($this->e2i($res['id']));
		/**
		 * 2016-07-10
		 * @uses \Magento\Sales\Model\Order\Payment\Transaction::TYPE_PAYMENT —
		 * это единственный транзакция без специального назначения,
		 * и поэтому мы можем безопасно его использовать
		 * для сохранения информации о нашем запросе к платёжной системе.
		 */
		$this->ii()->addTransaction(T::TYPE_PAYMENT);
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