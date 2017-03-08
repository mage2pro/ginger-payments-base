<?php
namespace Df\GingerPaymentsBase;
use Df\GingerPaymentsBase\Source\Option as OS;
use Df\Payment\Settings\Options as O;
/**
 * 2017-02-25
 * @method static Settings s()
 * @see \Dfe\GingerPayments\Settings
 * @see \Dfe\KassaCompleet\Settings
 */
abstract class Settings extends \Df\Payment\Settings {
	/**
	 * 2017-03-03
	 * @used-by \Df\GingerPaymentsBase\ConfigProvider::config()
	 * @return O
	 */
	final function options() {
		/** @var OS $os */
		$os = df_sc(df_con_heir($this, OS::class));
		return $this->test() ? $os->optionsTest() : $this->_options($os)->o();
	}
}