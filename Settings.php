<?php
namespace Dfe\GingerPaymentsBase;
use Dfe\GingerPaymentsBase\Source\Option as OS;
# 2017-02-25
/** @method static Settings s() */
final class Settings extends \Df\Payment\Settings {
	/**
	 * 2017-03-29
	 * https://github.com/mage2pro/ginger-payments/blob/1.0.3/etc/config.xml?ts=4#L17
	 * https://github.com/mage2pro/kassa-compleet/blob/1.0.3/etc/config.xml?ts=4#L17
	 * @used-by \Dfe\GingerPaymentsBase\Method::optionI2E()
	 */
	function btId():string {return $this->v();}

	/**
	 * 2017-03-29
	 * @used-by \Dfe\GingerPaymentsBase\Api::__construct()
	 */
	function domain():string {return $this->v();}

	/**
	 * 2017-03-03
	 * @used-by \Dfe\GingerPaymentsBase\ConfigProvider::options()
	 * @return array(<value> => <label>)
	 */
	function options():array {return $this->test() ? $this->os()->optionsTest() : $this->_options($this->os())->o();}

	/**
	 * 2017-03-28
	 * @used-by self::options()
	 * @used-by \Dfe\GingerPaymentsBase\Block\Info::prepareCommon()
	 */
	function os():OS {return dfc($this, function():OS {return df_sc(df_con_heir($this->m(), OS::class));});}
}