<?php
namespace Df\GingerPaymentsBase\W;
// 2017-03-16
final class Event extends \Df\PaypalClone\W\Event {
	/**
	 * 2017-03-16
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_idE()
	 * @used-by \Df\PaypalClone\W\Event::idE()
	 * @return string
	 */
	protected function k_idE() {return 'STUB';}

	/**
	 * 2017-03-09
	 * @override
	 * @see \Df\Payment\W\Event::k_pid()
	 * @used-by \Df\Payment\W\Event::pid()
	 * @return string
	 */
	protected function k_pid() {return 'order_id';}

	/**
	 * 2017-03-18
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_signature()
	 * @used-by \Df\PaypalClone\W\Event::signatureProvided()
	 * @return string
	 */
	protected function k_signature() {return 'STUB';}

	/**
	 * 2017-03-18
	 * @override
	 * @see \Df\PaypalClone\W\Event::k_status()
	 * @used-by \Df\PaypalClone\W\Event::status()
	 * @return string
	 */
	protected function k_status() {return 'STUB';}

	/**
	 * 2017-03-18
	 * @override
	 * @see \Df\PaypalClone\W\Event::statusExpected()
	 * @used-by \Df\PaypalClone\W\Event::isSuccessful()
	 * @return string|int
	 */
	protected function statusExpected() {return 'STUB';}
}