<?php
namespace Df\GingerPaymentsBase\W;
use Df\GingerPaymentsBase\Method as M;
use Df\Payment\W\Strategy\ConfirmPending;
/**
 * 2017-03-09
 * @method Event e()
 * @method M m()
 */
final class Handler extends \Df\Payment\W\Handler {
	/**
	 * 2017-03-26
	 * https://s3-eu-west-1.amazonaws.com/wl1-apidocs/api.kassacompleet.nl/index.html#possible-returned-order-statuses
	 * @override
	 * @see \Df\Payment\W\Handler::strategyC()
	 * @used-by \Df\Payment\W\Handler::handle()
	 * @return string|null
	 */
	protected function strategyC() {return
		in_array($this->m()->api()->orderGet($this->e()->idBase())['status'], [
			'completed', 'processing'
		]) ? ConfirmPending::class : null
	;}
}