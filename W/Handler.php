<?php
namespace Df\GingerPaymentsBase\W;
use Df\GingerPaymentsBase\Method as M;
use Df\StripeClone\W\Strategy\ConfirmPending;
// 2017-03-09
/** @method M m() */
final class Handler extends \Df\StripeClone\W\Handler {
	/**
	 * 2017-03-26
	 * https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#possible-returned-order-statuses
	 * @override
	 * @see \Df\StripeClone\W\Handler::strategyC()
	 * @used-by \Df\StripeClone\W\Handler::_handle()
	 * @return string|null
	 */
	protected function strategyC() {return
		in_array($this->m()->api()->orderGet($this->e()->idBase())['status'], [
			'completed', 'processing'
		]) ? ConfirmPending::class : null
	;}
}