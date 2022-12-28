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
	 */
	protected function k_pidSuffix():string {return 'order_id';}

	/**
	 * 2017-03-26 The primary data have a flat structure.
	 * @override
	 * @see \Df\StripeClone\W\Event::roPath()
	 * @used-by \Df\StripeClone\W\Event::k_pid()
	 * @used-by \Df\StripeClone\W\Event::ro()
	 */
	protected function roPath():string {return '';}

	/**
	 * 2017-03-26
	 * @override
	 * @see \Df\Payment\W\Event::ttCurrent()
	 * @used-by \Df\StripeClone\W\Nav::id()
	 * @used-by \Df\Payment\W\Strategy\ConfirmPending::_handle()
	 */
	function ttCurrent():string {return self::T_CAPTURE;}

	/**
	 * 2017-03-26
	 * @override
	 * @see \Df\StripeClone\W\Event::ttParent()
	 * @used-by \Df\StripeClone\W\Nav::pidAdapt()
	 */
	function ttParent():string {return self::T_INIT;}
}