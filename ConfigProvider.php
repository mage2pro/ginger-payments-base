<?php
namespace Df\GingerPaymentsBase;
/**
 * 2017-03-03
 * The class is not abstract,
 * because it is used as a base for virtual types in the following modules:
 * 1) GingerPayments:
 * https://github.com/mage2pro/ginger-payments/blob/0.0.8/etc/frontend/di.xml?ts=4#L13-L15
 * https://github.com/mage2pro/ginger-payments/blob/0.0.8/etc/frontend/di.xml?ts=4#L9
 *
 * 2) KassaCompleet:
 * @method Settings s()
 */
class ConfigProvider extends \Df\Payment\ConfigProvider {}