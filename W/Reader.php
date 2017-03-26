<?php
namespace Df\GingerPaymentsBase\W;
/**
 * 2017-03-16
 * 2017-03-26
 * https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#webhooks
 * An example of the notification:
 *	{
 *		"event": "status_changed",
 *		"order_id": "0125e02b-557c-4fb5-956a-d22662d71ad9",
 *		"project_id": "1ef558ed-d77d-470d-b43b-c0f4a131bcef"
 *	}
 */
final class Reader extends \Df\Payment\W\Reader\Json {
	/**             
	 * 2017-03-26
	 * @override
	 * @see \Df\Payment\W\Reader::kt()
	 * @used-by \Df\Payment\W\Reader::t()
	 * @return string
	 */
	protected function kt() {return 'event';}
}