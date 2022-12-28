<?php
namespace Df\GingerPaymentsBase;
use Df\GingerPaymentsBase\Settings as S;
use Df\Payment\ConfigProvider\IOptions;
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
 * @method Method m()
 * @method S s()
 * 2022-11-07 @noinspection PhpSuperClassIncompatibleWithInterfaceInspection It is a false positive.
 */
final class ConfigProvider extends \Df\Payment\ConfigProvider implements IOptions {
	/**
	 * 2017-09-18
	 * @override
	 * @see \Df\Payment\ConfigProvider\IOptions::options()
	 * @used-by \Df\Payment\ConfigProvider::configOptions()
	 * @return array(array('label' => string, 'value' => int|string))
	 */
	function options():array {return $this->s()->options();}
	
	/**
	 * 2017-03-03
	 * @override
	 * @see \Df\Payment\ConfigProvider::config()
	 * @used-by \Df\Payment\ConfigProvider::getConfig()
	 * @return array(string => mixed)
	 */
	protected function config():array {/** @var S $s */ $s = $this->s(); return [
		# 2017-03-04
		# @used-by Df_GingerPaymentsBase/main::banks()
	  	# https://github.com/mage2pro/ginger-payments-base/blob/0.2.3/view/frontend/web/main.js?ts=4#L7-L21
		'banks' => $this->m()->api()->idealBanks()
		  /**
		   * 2017-03-09 @used-by Df_GingerPaymentsBase/bankTransfer
		   * 2019-09-28
		   * @see \Dfe\ACH\ConfigProvider::config()
		   * https://github.com/mage2pro/ach/blob/0.0.4/ConfigProvider.php#L19
		   */
		,'btCheckoutMessage' => $s->v('btCheckoutMessage')
	] + self::configOptions($this) + parent::config();}
}