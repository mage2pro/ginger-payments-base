<?php
namespace Df\GingerPaymentsBase\Source;
/**
 * 2017-03-01
 * @see \Dfe\GingerPayments\Source\Option
 * @see \Dfe\KassaCompleet\Source\Option
 * @method static Option s()
 */
class Option extends \Df\Config\SourceT {
	/**
	 * 2017-03-01
	 * @override
	 * @see \Df\Config\Source::map()
	 * @used-by \Df\Config\Source::toOptionArray()
	 * @return array(string => string)
	 */
	final protected function map() {return ['ideal' => 'iDEAL'];}
}