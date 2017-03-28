<?php
namespace Df\GingerPaymentsBase;
use Df\GingerPaymentsBase\Source\Option as OS;
use Df\Payment\Settings\Options as O;
// 2017-02-25
/** @method static Settings s() */
final class Settings extends \Df\Payment\Settings {
	/**
	 * 2017-03-03
	 * @used-by \Df\GingerPaymentsBase\ConfigProvider::config()
	 * @return O
	 */
	function options() {return
		$this->test() ? $this->os()->optionsTest() : $this->_options($this->os())->o()
	;}

	/**
	 * 2017-03-28
	 * @used-by options()
	 * @used-by \Df\GingerPaymentsBase\Block\Info::siOption()
	 * @return OS
	 */
	function os() {return dfc($this, function() {return df_sc(
		df_con_heir($this->m(), OS::class)
	);});}
}