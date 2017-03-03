<?php
namespace Df\GingerPaymentsBase;
/**
 * 2017-03-03
 * The class is not abstract,
 * because it is used as a base for virtual types in the following modules:
 * 1) GingerPayments
 * 2) KassaCompleet
 * @method Settings s()
 */
class ConfigProvider extends \Df\Payment\ConfigProvider {}