<?php
namespace Df\GingerPaymentsBase\W;
/**
 * 2017-03-09
 * https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#webhooks
 * An example of the notification:
 *	{
 *		"event": "status_changed",
 *		"order_id": "0125e02b-557c-4fb5-956a-d22662d71ad9",
 *		"project_id": "1ef558ed-d77d-470d-b43b-c0f4a131bcef"
 *	}
 * @see \Dfe\GingerPayments\W\Handler
 * @see \Dfe\KassaCompleet\W\Handler
 */
class Handler extends \Df\PaypalClone\W\Handler {
	/**
	 * 2017-03-09
	 * Kassa Compleet и Ginger Payments не подписывают оповещения.
	 * @todo Мы должны валидировать оповещение посредством запроса к API.
	 * @override
	 * @see \Df\PaypalClone\W\Handler::validate()
	 * @used-by \Df\Payment\W\Handler::handle()
	 * @return void
	 * @throws \Exception
	 */
	final protected function validate() {}
}