// 2017-03-02
// @see https://github.com/mage2pro/ginger-payments/blob/0.0.6/view/frontend/web/main.js
// @see https://github.com/mage2pro/kassa-compleet/blob/0.1.1/view/frontend/web/main.js
define([
	'df', 'df-lodash', 'Df_Payment/withOptions', 'jquery'
], function(df, _, parent, $) {'use strict';
/** 2017-09-06 @uses Class::extend() https://github.com/magento/magento2/blob/2.2.0-rc2.3/app/code/Magento/Ui/view/base/web/js/lib/core/class.js#L106-L140 */	
return parent.extend({
	/**
	 * 2017-03-04
	 * @used-by Dfe_GingerPaymentsBase/ideal
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.2.3/view/frontend/web/template/bank.html?ts=4#L6
	 * @returns {Object}[]
	 */
	banks: function () {return $.map(this.config('banks'), function(v, k) {return {
		label: v, value: k
	};});},
	defaults: {
		// 2017-03-05
		// @used-by dfData()
		// @used-by Dfe_GingerPaymentsBase/ideal
		// https://github.com/mage2pro/ginger-payments-base/blob/0.2.3/view/frontend/web/template/bank.html?ts=4#L10
		bank: ''
	},
	/**
	 * 2017-03-01
	 * 2017-07-26
	 * These data are submitted to the M2 server part
	 * as the `additional_data` property value on the «Place Order» button click:
	 * @used-by Df_Payment/mixin::getData():
	 *		getData: function() {return {additional_data: this.dfData(), method: this.item.method};},
	 * https://github.com/mage2pro/core/blob/2.8.4/Payment/view/frontend/web/mixin.js#L224
	 * @override
	 * @see Df_Payment/withOptions::dfData()
	 * https://github.com/mage2pro/core/blob/2.8.4/Payment/view/frontend/web/withOptions.js#L19-L33
	 * @see \Dfe\GingerPaymentsBase\Method::$II_BANK
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.2.2/Method.php?ts=4#L68
	 * @see \Dfe\GingerPaymentsBase\Method::$II_OPTION
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.2.2/Method.php?ts=4#L75
	 * @returns {Object}
	 */
	dfData: function() {return _.assign(this._super(), df.clean({
		bank: 'ideal' === this.option() ? this.bank : null
	}));},
	/**
	 * 2017-03-03
	 * @override
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.1.0/view/frontend/web/main.less#L2
	 * @see Df_Payment/mixin::dfFormCssClasses()
	 * https://github.com/mage2pro/core/blob/2.0.25/Payment/view/frontend/web/mixin.js?ts=4#L165
	 * @used-by Df_Payment/mixin::dfFormCssClassesS()
	 * https://github.com/mage2pro/core/blob/2.0.25/Payment/view/frontend/web/mixin.js?ts=4#L171
	 * @returns {String}[]
	 */
	dfFormCssClasses: function() {return this._super().concat(['df_ginger_payments_base']);},
	/**
	 * 2017-03-04
	 * @override
	 * @see Df_Payment/withOptions::optionAfter()
	 * https://github.com/mage2pro/core/blob/2.0.35/Payment/view/frontend/web/withOptions.js?ts=4#L58-L68
	 * @used-by Df_Payment/withOptions
	 * https://github.com/mage2pro/core/blob/2.0.35/Payment/view/frontend/web/template/withOptions.html?ts=4#L20
	 * @param {String} v
	 * @returns {String}
	 */
	optionAfter: function(v) {return df.k({
		'bank-transfer': 'Dfe_GingerPaymentsBase/bankTransfer'
		,ideal: 'Dfe_GingerPaymentsBase/ideal'
	}, v, this._super(v));}
});});