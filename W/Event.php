<?php
namespace Df\GingerPaymentsBase\W;
/**
 * 2017-03-16
 * https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#webhooks
 * An example of the notification:
 *	{
 *		"event": "status_changed",
 *		"order_id": "0125e02b-557c-4fb5-956a-d22662d71ad9",
 *		"project_id": "1ef558ed-d77d-470d-b43b-c0f4a131bcef"
 *	}
 */
final class Event extends \Df\StripeClone\W\Event {
	/**
	 * 2017-03-26
	 * @override
	 * @see \Df\StripeClone\W\Event::k_pidSuffix()
	 * @used-by \Df\StripeClone\W\Event::k_pid()
	 * @return string
	 */
	protected function k_pidSuffix() {return 'order_id';}

	/**
	 * 2017-03-26
	 * Основные данные события расположены на верхнем уровне вложенности.
	 * @override
	 * @see \Df\StripeClone\W\Event::roPath()
	 * @used-by \Df\StripeClone\W\Event::k_pid()
	 * @used-by \Df\StripeClone\W\Event::ro()
	 * @return null
	 */
	protected function roPath() {return null;}

	/**
	 * 2017-03-26
	 * @override
	 * @see \Df\StripeClone\W\Event::ttCurrent()
	 * @used-by \Df\StripeClone\W\Event::id()
	 * @used-by \Df\StripeClone\W\Strategy\Authorize::action()
	 * @return string
	 */
	function ttCurrent() {return self::T_CAPTURE;}

	/**
	 * 2017-03-26
	 * @override
	 * @see \Df\StripeClone\W\Event::ttParent()
	 * @used-by \Df\StripeClone\W\Nav::pidAdapt()
	 * @return string
	 */
	function ttParent() {return self::T_INIT;}

	/**
	 * 2017-03-26
	 * Первичная транзакция.
	 * Она всегда соответствует неподтверждённому состоянию платежа.
	 * @used-by ttParent()
	 * @used-by \Df\GingerPaymentsBase\Init\Action::transId()
	 */
	const T_INIT = 'init';
}