<?php
namespace Df\GingerPaymentsBase;
use Df\GingerPaymentsBase\Source\Option as SO;
use Magento\Sales\Model\Order\Address as OA;
use Magento\Sales\Model\Order\Item as OI;
// 2017-03-05
/** @method Method m() */
final class Charge extends \Df\Payment\Charge {
	/**
	 * 2017-03-06
	 * @used-by p()
	 * @return array(string => mixed)
	 */
	private function pCharge() {return [
		// 2017-02-27
		// «Order amount (including VAT)».
		self::K_AMOUNT => $this->amountF()
		// 2017-02-28
		// The «client» property is present only in the Kassa Compleet's JSON schema,
		// but Ginger Payments does not fail if it is specified (just silently ignores it).
		,'client' => $this->pClient()
		// 2017-02-28
		// [Ginger Payments] A documentation for the «customer» parameter
		// in the «POST /v1/orders/» request: https://mage2.pro/t/3394
		// The official Ginger Payments and Kassa Compleet extensions for Magento 1.x
		// pass the same customer data to «POST /v1/orders/» besides the «customer/locale» format:
		// https://mage2.pro/t/3445
		,'customer' => $this->pCustomer()
		// 2017-02-27
		// The currency
		,'currency' => $this->currencyC()
		// 2017-02-27
		// «A description (optional)»
		// I did not find any limitations on it.
		,'description' => $this->description()
		// 2017-02-27
		// The expiration period in ISO 8601 format (optional)
		// [Ginger Payments] The «expiration_period» parameter for POST /v1/orders/ is undocumented: https://mage2.pro/t/3388
		,'expiration_period' => 'PT15M'
		// 2017-02-28
		// Arbitrary data.
		,'extra' => $this->metadata()
		// 2017-02-27
		// Your identifier for the order (optional)
		,'merchant_order_id' => $this->id()
		// 2017-02-28
		// [Ginger Payments] Is any documentation on the «order_lines» property
		// of the «POST /v1/orders/» request? https://mage2.pro/t/3450
		,'order_lines' => $this->pOrderLines()
		// 2017-02-27
		// «The return URL (optional)».
		// «Your customer will be redirected here after payment»
		// This parameter is required for iDEAL: https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#creating-an-ideal-order
		// https://www.gingerpayments.com/docs#creating-an-ideal-order
		// 2017-07-07
		// Сделал по аналогии с модулем allPay:
		// https://github.com/mage2pro/allpay/blob/1.1.31/Charge.php?ts=4#L365-L378
		,'return_url' => $this->customerReturnRemote()
		// 2017-03-01
		// Замечение №1
		// Это свойство обязательно, иначе будет сбой:
		// «Array does not contain an element with key "transactions"».
		// Замечение №2
		// [Ginger Payments] The referenced «transactions.json» part
		// is missed in the JSON Schema of a «POST /v1/orders/» request: https://mage2.pro/t/3456
		,self::K_TRANSACTIONS => $this->pTransactions()
		// 2017-02-28
		// [Kassa Compleet] The «webhook_url» property allows to set the webhook URL dynamically
		// in a «POST /v1/orders/» request: https://mage2.pro/t/3453
		//
		// Whether Ginger Payments allows to set the webhook URL dynamically
		// in a «POST /v1/orders/» request? https://mage2.pro/t/3452
		//
		// Надо будет сделать по аналогии с модулем allPay:
		// https://github.com/mage2pro/allpay/blob/1.1.31/Charge.php?ts=4#L431-L454
		,'webhook_url' => $this->callback()
	];}

	/**
	 * 2017-03-06
	 * @used-by pCharge()
	 * @return array(string => mixed)
	 */
	private function pClient() {return [
		'platform_name' => "Mage2.PRO «{$this->m()->titleB()}» extension for Magento 2 (https://mage2.pro)"
		,'platform_version' => df_package_version($this->m())
		// 2017-02-28
		// It will be rewritten to «Ginger-Python-ApiClient/0.8.1 Requests/2.11.1 Python/2.7.10».
		,'user_agent' => 'Mage2.PRO (https://mage2.pro)'
	];}

	/**
	 * 2017-03-06
	 * @used-by pCharge()
	 * @return array(string => string|string[])
	 */
	private function pCustomer() {/** @var OA $a */ $a = $this->addressB(); return [
		// 2017-02-28 Test addresses for some countries: https://mage2.pro/t/2555
		'address' => df_cc_s($a->getStreet())
		,'address_type' => 'billing'
		// 2017-02-28
		// [Kassa Compleet] What is the right format of a customer's birth date in a «POST /v1/orders/» request?
		// https://mage2.pro/t/3448
		// [Kassa Compleet] The «customer/birth_date» property is absent in the JSON Schema
		// of a «POST /v1/orders/» request, but is passed by the official extension for Magento 1.x:
		// https://mage2.pro/t/3447
		// [Ginger Payments] The «customer/birth_date» property is absent in the JSON Schema
		// of a «POST /v1/orders/» request, but is passed by the official extension for Magento 1.x:
		// https://mage2.pro/t/3446
		,'birth_date' => $this->customerDobS(\Zend_Date::ISO_8601)
		,'country' => $a->getCountryId()
		,'email_address' => $this->customerEmail()
		,'first_name' => $this->customerNameF()
		,'forwarded_ip' => $this->customerIp()
		// 2017-02-28 "male", "female", "other", null
		,'gender' => $this->customerGender('male', 'female')
		,'housenumber' => ''
		,'ip_address' => $this->customerIp()
		,'last_name' => $this->customerNameL()
		// 2017-02-28
		// [Kassa Compleet] What is the right format of a customer's locale in a «POST /v1/orders/» request?
		// https://mage2.pro/t/3444
		// [Ginger Payments] The «customer/locale» property is absent in the JSON Schema
		// of a «POST /v1/orders/» request, but is passed by the official extension for Magento 1.x:
		// https://mage2.pro/t/3443
		// The official Ginger Payments and Kassa Compleet extensions for Magento 1.x
		// pass the same customer data to «POST /v1/orders/» besides the «customer/locale» format:
		// https://mage2.pro/t/3445
		,'locale' => $this->locale()
		,'merchant_customer_id' => $this->o()->getCustomerId() ?: $this->customerName()
		,'phone_numbers' => df_clean([$a->getTelephone()])
		// 2017-02-28 Test addresses for some countries: https://mage2.pro/t/2555
		,'postal_code' => $a->getPostcode()
		// 2017-03-06 I did it intentionally.
		,'referrer' => 'https://mage2.pro'
		,'user_agent' => 'Mage2.PRO'
	];}

	/**
	 * 2017-03-06
	 * https://mage2.pro/t/3411
	 * @used-by pCharge()
	 * @return array(string => string|int|float)
	 */
	private function pOrderLines() {return array_merge(
		$this->pOrderLines_products(), [$this->pOrderLines_shipping()]
	);}

	/**
	 * 2017-03-06
	 * https://mage2.pro/t/3411
	 * @used-by pOrderLines()
	 * @return array(string => string|int|float)
	 */
	private function pOrderLines_products() {return $this->oiLeafs(function(OI $i) {return [
		// 2017-03-06
		// «Amount for a single item (including VAT) in cents»
		'amount' => $this->cFromDocF(df_oqi_price($i, true))
		,'currency' => $this->currencyC()
		,'discount_rate' => 0
		,'ean' => ''
		// 2017-03-06
		// «Order line identifier»
		,'id' => $i->getSku()
		// 2017-03-06
		// «Item image URI»
		,'image_url' => df_oqi_image($i)
		// 2017-03-06
		// «Merchant's internal order line identifier»
		,'merchant_order_line_id' => $i->getSku()
		// 2017-03-06
		// «Name, usually a short description»
		,'name' => $i->getName()
		,'quantity' => df_oqi_qty($i)
		// 2017-03-06
		// «Item product page URI»
		,'url' => df_oqi_url($i)
		// 2017-03-06
		// «Type: physical, discount or shipping_fee»
		,'type' => 'physical'
		// 2017-02-28
		// Kassa Compleet and Ginger Payments use different formats
		// for the «order_lines/order_line/vat_percentage» property
		// of a «POST /v1/orders/» request: https://mage2.pro/t/3451
		,'vat_percentage' => df_oqi_tax_rate($i, $this->m()->vatIsInteger())
	];});}

	/**
	 * 2017-03-06
	 * https://mage2.pro/t/3411
	 * @used-by pOrderLines()
	 * @return array(string => string|int|float)
	 */
	private function pOrderLines_shipping() {return [
		// 2017-03-06
		// «Amount for a single item (including VAT) in cents»
		'amount' => $this->cFromDocF($this->o()->getShippingAmount())
		,'currency' => $this->currencyC()
		// 2017-03-06
		// «Order line identifier»
		,'id' => 'shipping'
		// 2017-03-06
		// «Merchant's internal order line identifier»
		,'merchant_order_line_id' => 'shipping'
		// 2017-03-06
		// «Name, usually a short description»
		,'name' => $this->o()->getShippingDescription()
		,'quantity' => 1
		// 2017-03-06
		// «Type: physical, discount or shipping_fee»
		,'type' => 'shipping_fee'
		// 2017-03-09
		// Это поле обязательно.
		,'vat_percentage' => 0
	];}

	/**
	 * 2017-03-07
	 * Значением «payment_method_details» не может быть пустой массив:
	 * «[] is not valid under any of the given schemas»
	 * @used-by pCharge()
	 * @return array(string => mixed)
	 */
	private function pTransactions() {/** @var Method $m */ $m = $this->m(); return [
		// 2017-02-27
		// The payment method
		[self::K_PAYMENT_METHOD => $m->optionE()] + (SO::IDEAL !== $m->optionE() ? [] : [
			// 2017-02-27
			// Extra details required for this payment method
			self::K_PAYMENT_METHOD_DETAILS => [
				// 2017-02-27
				// This parameter is required:
				// https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#creating-an-ideal-order
				// https://www.gingerpayments.com/docs#creating-an-ideal-order
				self::K_ISSUER_ID => $m->bank()
			]
		])
	];}

	/**
	 * 2017-03-29
	 * @used-by pCharge()
	 * @used-by \Df\GingerPaymentsBase\Block\Info::btInstructions()
	 */
	const K_AMOUNT = 'amount';

	/**
	 * 2017-03-28
	 * @used-by pTransactions()
	 * @used-by \Df\GingerPaymentsBase\Block\Info::prepareCommon()
	 */
	const K_ISSUER_ID = 'issuer_id';

	/**
	 * 2017-03-28
	 * @used-by pTransactions()
	 * @used-by \Df\GingerPaymentsBase\Block\Info::optionCode()
	 */
	const K_PAYMENT_METHOD = 'payment_method';

	/**
	 * 2017-03-28
	 * @used-by pTransactions()
	 * @used-by \Df\GingerPaymentsBase\Block\Info::psDetails()
	 */
	const K_PAYMENT_METHOD_DETAILS = 'payment_method_details';

	/**
	 * 2017-03-28
	 * @used-by pCharge()
	 * @used-by \Df\GingerPaymentsBase\Block\Info::psTransaction()
	 */
	const K_TRANSACTIONS = 'transactions';

	/**
	 * 2017-03-06
	 * @used-by \Df\GingerPaymentsBase\Init\Action::req()
	 * @param Method $m
	 * @return array(string => mixed)
	 */
	static function p(Method $m) {return (new self($m))->pCharge();}
}