<?php
namespace Df\GingerPaymentsBase;
use Df\GingerPaymentsBase\Settings as S;
/**
 * 2017-03-03
 * The class is not abstract,
 * because it is used as a base for virtual types in the following modules:
 *
 * 1) GingerPayments:
 * https://github.com/mage2pro/ginger-payments/blob/0.0.8/etc/frontend/di.xml?ts=4#L13-L15
 * https://github.com/mage2pro/ginger-payments/blob/0.0.8/etc/frontend/di.xml?ts=4#L9
 *
 * 2) KassaCompleet:
 * https://github.com/mage2pro/kassa-compleet/tree/0.1.3/etc/frontend/di.xml?ts=4#L13-L15
 * https://github.com/mage2pro/kassa-compleet/tree/0.1.3/etc/frontend/di.xml?ts=4#L9
 *
 * @method S s()
 */
final class ConfigProvider extends \Df\Payment\ConfigProvider {
	/**
	 * 2016-08-04
	 * @override
	 * @see \Df\Payment\ConfigProvider::config()
	 * @used-by \Df\Payment\ConfigProvider::getConfig()
	 * @return array(string => mixed)
	 */
	protected function config() {/** @var S $s */ $s = $this->s(); return [
		'options' => $s->options()
	] + parent::config();}
}