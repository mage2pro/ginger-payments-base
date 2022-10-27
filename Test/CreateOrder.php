<?php
namespace Df\GingerPaymentsBase\Test;
/**
 * 2017-02-27
 * @see \Df\GingerPaymentsBase\Test\CreateOrder\Ideal
 * @see \Dfe\GingerPayments\Test\CreateOrder\BankTransfer
 * @see \Dfe\KassaCompleet\Test\CreateOrder\BankTransfer
 */
abstract class CreateOrder extends CaseT {
	/**
	 * 2017-02-27
	 * @used-by self::t01_success()
	 * @see \Df\GingerPaymentsBase\Test\CreateOrder\Ideal::method()
	 * @see \Dfe\GingerPayments\Test\CreateOrder\BankTransfer::method()
	 * @see \Dfe\KassaCompleet\Test\CreateOrder\BankTransfer::method()
	 * @return string
	 */
	abstract protected function method();

	/**
	 * @test
	 * 2017-02-27
	 * [Ginger Payments] Which parameters can be passed to «POST /v1/orders/»? https://mage2.pro/t/3389
	 * [Ginger Payments] A JSON Schema of a «POST /v1/orders/» request: https://mage2.pro/t/3410
	 * [Kassa Compleet] A JSON Schema of a «POST /v1/orders/» request: https://mage2.pro/t/3411
	 */
	final function t01_success() {
		$this->api()->orderPost([
			# 2017-02-27
			# «Order amount (including VAT)».
			'amount' => 2500
			# 2017-02-28
			# The «client» property is present only in the Kassa Compleet's JSON schema,
			# but Ginger Payments does not fail if it is specified (just silently ignores it).
			,'client' => [
				'platform_name' => "Mage2.PRO «{$this->m()->titleB()}» extension for Magento 2 (https://mage2.pro)"
				,'platform_version' => df_package_version($this)
				# 2017-02-28
				# It will be rewritten to «Ginger-Python-ApiClient/0.8.1 Requests/2.11.1 Python/2.7.10».
				,'user_agent' => 'Mage2.PRO (https://mage2.pro)'
			]
			# 2017-02-28
			# [Ginger Payments] A documentation for the «customer» parameter
			# in the «POST /v1/orders/» request: https://mage2.pro/t/3394
			# The official Ginger Payments and Kassa Compleet extensions for Magento 1.x
			# pass the same customer data to «POST /v1/orders/» besides the «customer/locale» format:
			# https://mage2.pro/t/3445
			,'customer' => $this->customer()
			# 2017-02-27
			# The currency
			,'currency' => 'EUR'
			# 2017-02-27
			# «A description (optional)»
			# I did not find any limitations on it.
			,'description' => 'An example of description.'
			# 2017-02-27
			# The expiration period in ISO 8601 format (optional)
			# [Ginger Payments] The «expiration_period» parameter for POST /v1/orders/ is undocumented: https://mage2.pro/t/3388
			,'expiration_period' => 'PT15M'
			# 2017-02-28
			# Arbitrary data.
			,'extra' => ['aaa' => 3, 'bbb' => 5]
			# 2017-02-27
			# Your identifier for the order (optional)
			,'merchant_order_id' => 'order-234192'
			# 2017-02-28
			# [Ginger Payments] Is any documentation on the «order_lines» property
			# of the «POST /v1/orders/» request? https://mage2.pro/t/3450
			,'order_lines' => [
				[
					'amount' => 1250
					,'currency' => 'EUR'
					,'discount_rate' => 0
					,'ean' => '12345'
					,'id' => '1'
					,'image_url' => 'https://mage2.pro/uploads/default/original/1X/ed63ec02f0651856b03670a04b03057758b4c8e8.png'
					,'merchant_order_line_id' => '11'
					,'name' => 'An order item'
					,'quantity' => 2
					,'url' => 'https://mage2.pro'
					,'type' => 'physical'
					# 2017-02-28
					# Kassa Compleet and Ginger Payments use different formats
					# for the «order_lines/order_line/vat_percentage» property
					# of a «POST /v1/orders/» request: https://mage2.pro/t/3451
					,'vat_percentage' => 17.5 * ($this->m()->vatIsInteger() ? 100 : 1)
				]
			]
			/**
			 * 2017-02-27
			 * «The return URL (optional)».
			 * «Your customer will be redirected here after payment»
			 * This parameter is required for iDEAL: https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#creating-an-ideal-order
			 * https://www.gingerpayments.com/docs#creating-an-ideal-order
			 * 2017-02-28
			 * @uses df_url_checkout_success() поставил временно:
			 * намного лучше будет сделать, как в модуле allPay:
			 * https://github.com/mage2pro/allpay/blob/1.1.31/Charge.php?ts=4#L365-L378
			 */
			,'return_url' => df_url_checkout_success()
			/**
			 * 2017-03-01
			 * Замечение №1
			 * Это свойство обязательно, иначе будет сбой:
			 * «Array does not contain an element with key "transactions"».
			 * Замечение №2
			 * [Ginger Payments] The referenced «transactions.json» part
			 * is missed in the JSON Schema of a «POST /v1/orders/» request: https://mage2.pro/t/3456
			 */
			,'transactions' => [df_clean([
				# 2017-02-27 The payment method.
				'payment_method' => $this->method()
				# 2017-02-27 Extra details required for this payment method.
				,'payment_method_details' => $this->params()
			])]
			/**
			 * 2017-02-28
			 * [Kassa Compleet] The «webhook_url» property allows to set the webhook URL dynamically
			 * in a «POST /v1/orders/» request: https://mage2.pro/t/3453
			 *
			 * Whether Ginger Payments allows to set the webhook URL dynamically
			 * in a «POST /v1/orders/» request? https://mage2.pro/t/3452
			 *
			 * Надо будет сделать по аналогии с модулем allPay:
			 * https://github.com/mage2pro/allpay/blob/1.1.31/Charge.php?ts=4#L431-L454
			 */
			,'webhook_url' => 'https://mage2.pro'
		]);
		print_r($this->api()->lastResponse());
	}

	/**
	 * 2017-02-27
	 * @used-by self::t01_success()
	 * @see \Df\GingerPaymentsBase\Test\CreateOrder\Ideal::params()
	 * @return string
	 */
	protected function params() {return [];}

	/**
	 * 2017-02-28
	 * The official Ginger Payments and Kassa Compleet extensions for Magento 1.x
	 * pass the same customer data to «POST /v1/orders/» besides the «customer/locale» format:
	 * https://mage2.pro/t/3445
	 * @used-by self::t01_success()
	 * @return array(string => string)
	 */
	private function customer() {return [
		# 2017-02-28 Test addresses for some countries: https://mage2.pro/t/2555
		'address' => 'Amsterdam Rusland 17'
		,'address_type' => 'billing'
		# 2017-02-28
		# [Kassa Compleet] What is the right format of a customer's birth date in a «POST /v1/orders/» request?
		# https://mage2.pro/t/3448
		# [Kassa Compleet] The «customer/birth_date» property is absent in the JSON Schema
		# of a «POST /v1/orders/» request, but is passed by the official extension for Magento 1.x:
		# https://mage2.pro/t/3447
		# [Ginger Payments] The «customer/birth_date» property is absent in the JSON Schema
		# of a «POST /v1/orders/» request, but is passed by the official extension for Magento 1.x:
		# https://mage2.pro/t/3446
		,'birth_date' => '1982-07-08 00:00:00'
		,'country' => 'NL'
		,'email_address' => 'admin@mage2.pro'
		,'first_name' => 'Dmitry'
		,'forwarded_ip' => '5.9.188.84'
		# "male", "female", "other", null
		,'gender' => 'male'
		,'housenumber' => '17'
		,'ip_address' => '5.9.188.84'
		,'last_name' => 'Fedyuk'
		# 2017-02-28
		# [Kassa Compleet] What is the right format of a customer's locale in a «POST /v1/orders/» request?
		# https://mage2.pro/t/3444
		# [Ginger Payments] The «customer/locale» property is absent in the JSON Schema
		# of a «POST /v1/orders/» request, but is passed by the official extension for Magento 1.x:
		# https://mage2.pro/t/3443
		# The official Ginger Payments and Kassa Compleet extensions for Magento 1.x
		# pass the same customer data to «POST /v1/orders/» besides the «customer/locale» format:
		# https://mage2.pro/t/3445
		,'locale' => 'nl_NL'
		,'merchant_customer_id' => '123'
		,'phone_numbers' => ['+31 20 623 1231']
		# 2017-02-28
		# Test addresses for some countries: https://mage2.pro/t/2555
		,'postal_code' => '1012'
		,'referrer' => 'https://mage2.pro'
		,'user_agent' => 'Mage2.PRO'
	];}
}