<?php
namespace Df\GingerPaymentsBase\W;
use Df\StripeClone\W\Strategy\ConfirmPending;
// 2017-03-09
final class Handler extends \Df\StripeClone\W\Handler {
	/**
	 * 2017-03-26
	 * @override
	 * @see \Df\StripeClone\W\Handler::strategyC()
	 * @used-by \Df\StripeClone\W\Handler::_handle()
	 * @return string
	 */
	protected function strategyC() {return ConfirmPending::class;}
}