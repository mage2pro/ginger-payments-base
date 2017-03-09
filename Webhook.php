<?php
namespace Df\GingerPaymentsBase;
/**
 * 2017-03-09
 * https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#webhooks
 * @see \Dfe\GingerPayments\Webhook
 * @see \Dfe\KassaCompleet\Webhook
 */
class Webhook extends \Df\PaypalClone\Confirmation {
	/**
	 * 2017-03-09
	 * @override
	 * @see \Df\Payment\Webhook::config()
	 * @used-by \Df\Payment\Webhook::configCached()
	 * @return array(string => mixed)
	 */
	final protected function config() {return [
		self::$externalIdKey => 'STUB'
		,self::$needCapture => true
		,self::$readableStatusKey => 'STUB'
		,self::$signatureKey => 'STUB'
		,self::$statusExpected => 1
		,self::$statusKey => 'STUB'
	];}

	/**
	 * 2017-03-09
	 * @override
	 * @see \Df\Payment\Webhook::parentIdRawKey()
	 * @used-by \Df\Payment\Webhook::parentIdRaw()
	 * @return string
	 */
	final protected function parentIdRawKey() {return 'order_id';}

	/**
	 * 2017-03-09
	 * Kassa Compleet и Ginger Payments не подписывают оповещения.
	 * @override
	 * @see \Df\PaypalClone\Webhook::validate()
	 * @used-by \Df\Payment\Webhook::handle()
	 * @return void
	 * @throws \Exception
	 */
	final protected function validate() {}
}