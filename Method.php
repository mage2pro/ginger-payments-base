<?php
namespace Df\GingerPaymentsBase;
use Df\GingerPaymentsBase\Source\Option as SO;
use Magento\Sales\Model\Order\Payment\Transaction as T;
/**
 * 2017-02-25
 * @see \Dfe\GingerPayments\Method
 * @see \Dfe\KassaCompleet\Method
 * @method Settings s()
 */
abstract class Method extends \Df\Payment\Method {
	/**
	 * 2017-03-06
	 * @used-by getConfigPaymentAction()
	 * @used-by \Df\GingerPaymentsBase\ConfigProvider::config()
	 * @used-by \Df\GingerPaymentsBase\T\CaseT::api()
	 * @used-by \Df\GingerPaymentsBase\W\Handler::strategyC()
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
	 * 2017-03-07 https://mage2.pro/t/3355/2
	 * @used-by \Df\GingerPaymentsBase\Charge::pTransactions()
	 * @return string
	 */
	final function optionE() {return dftr($this->option(), $this->optionI2E());}

	/**
	 * 2017-03-29 https://mage2.pro/t/3355/2
	 * @used-by \Df\GingerPaymentsBase\Block\Info::optionCodeI()
	 * @param string $v
	 * @return string
	 */
	final function optionI($v) {return dftr($v, array_flip($this->optionI2E()));}

	/**
	 * 2017-03-29
	 * @override
	 * @see \Df\Payment\Method::transUrl()
	 * @used-by \Df\Payment\Method::tidFormat()
	 * @param T $t
	 * @return string|null
	 */
	final protected function transUrl(T $t) {/** @var string|null $tmpl */ return
		!($tmpl = $this->s('transUrl')) ? null :sprintf($tmpl, df_trd($t, self::IIA_TR_RESPONSE)['id'])
	;}

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
	 * @used-by optionE()
	 * @return string
	 */
	private function option() {return df_result_sne($this->iia(self::$II_OPTION));}

	/**
	 * 2017-03-29
	 * @used-by optionE()
	 * @used-by optionI()
	 * @return array(string => string)
	 */
	private function optionI2E() {return dfc($this, function() {return [SO::BT => $this->s()->btId()];});}

	/**
	 * 2017-03-05 https://github.com/mage2pro/ginger-payments-base/blob/0.2.2/view/frontend/web/main.js?ts=4#L25
	 * @used-by bank()
	 * @used-by iiaKeys()
	 */
	private static $II_BANK = 'bank';

	/**
	 * 2017-03-05
	 * https://github.com/mage2pro/core/blob/2.12.17/Payment/view/frontend/web/withOptions.js#L56-L72
	 * @used-by iiaKeys()
	 * @used-by option()
	 */
	private static $II_OPTION = 'option';
}