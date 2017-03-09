<?php
namespace Df\GingerPaymentsBase;
/**
 * 2017-03-09
 * https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#webhooks
 * An example of the notification:
 *	{
 *		"event": "status_changed",
 *		"order_id": "0125e02b-557c-4fb5-956a-d22662d71ad9",
 *		"project_id": "1ef558ed-d77d-470d-b43b-c0f4a131bcef"
 *	}
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
	 * @todo Мы должны валидировать оповещение посредством запроса к API.
	 * @override
	 * @see \Df\PaypalClone\Webhook::validate()
	 * @used-by \Df\Payment\Webhook::handle()
	 * @return void
	 * @throws \Exception
	 */
	final protected function validate() {}
}