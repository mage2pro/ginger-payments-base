// 2017-03-02
// @see https://github.com/mage2pro/ginger-payments/blob/0.0.6/view/frontend/web/main.js
// @see https://github.com/mage2pro/kassa-compleet/blob/0.1.1/view/frontend/web/main.js
define([
	'df', 'df-lodash', 'Df_Payment/withOptions', 'jquery'
], function(df, _, parent, $) {'use strict'; return parent.extend({
	/**
	 * 2017-03-04
	 * @used-by Df_GingerPaymentsBase/bank
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.2.3/view/frontend/web/template/bank.html?ts=4#L6
	 * @returns {Object}[]
	 */
	banks: function () {
		/** @type {Boolean} */
		var t = this.isTest();
		// 2017-03-05
		// I make the banks names in the test mode more real (and shorter).
		/** @type {Object} */
		var tm = {INGBNL2A: 'ING Bank', RABONL2U: 'Rabobank'};
		return $.map(this.config('banks'), function(v, k) {return {
			label: t && tm[k] ? tm[k] : v, value: k
		};});
	},
	defaults: {
		// 2017-03-05
		// @used-by dfData()
		// @used-by Df_GingerPaymentsBase/bank
		// https://github.com/mage2pro/ginger-payments-base/blob/0.2.3/view/frontend/web/template/bank.html?ts=4#L10
		bank: ''
		// 2017-03-02
		// @used-by Df_Payment/main
		// https://github.com/mage2pro/core/blob/2.0.36/Payment/view/frontend/web/template/main.html?ts=4#L36-L38
		,df: {formTemplate: 'Df_GingerPaymentsBase/form'}
	},
	/**
	 * 2016-08-08
	 * 2017-03-01
	 * Задаёт набор передаваемых на сервер при нажатии кнопки «Place Order» данных.
	 * @override
	 * @see mage2pro/core/Payment/view/frontend/web/mixin.js::dfData()
	 * @used-by mage2pro/core/Payment/view/frontend/web/mixin.js::getData()
	 * https://github.com/mage2pro/core/blob/2.0.21/Payment/view/frontend/web/mixin.js?ts=4#L208-L225
	 * @see \Df\GingerPaymentsBase\Method::$II_BANK
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.2.2/Method.php?ts=4#L68
	 * @see \Df\GingerPaymentsBase\Method::$II_OPTION
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.2.2/Method.php?ts=4#L75
	 * @returns {Object}
	 */
	dfData: function() {return df.o.merge(this._super(), df.clean({
		bank: this.idealSelected() ? this.bank : null
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
	 * 2017-03-05
	 * @used-by dfData()
	 * @used-by Df_GingerPaymentsBase/bank
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.2.3/view/frontend/web/template/bank.html?ts=4#L4
	 * @return {Boolean}
	 */
	idealSelected: function() {return 'ideal' === this.option();},
	/**
	 * 2017-03-04
	 * @override
	 * @see Df_Payment/withOptions::optionAfter()
	 * https://github.com/mage2pro/core/blob/2.0.35/Payment/view/frontend/web/withOptions.js?ts=4#L58-L68
	 * @used-by Df_Payment/withOptions
	 * https://github.com/mage2pro/core/blob/2.0.35/Payment/view/frontend/web/template/withOptions.html?ts=4#L20
	 * @param {String} v
	 * @returns {String}
	 * @see https://github.com/mage2pro/ginger-payments-base/blob/0.1.9/view/frontend/web/template/idealBank.html?ts=4
	 */
	optionAfter: function(v) {return 'ideal' !== v ? this._super(v) : 'Df_GingerPaymentsBase/bank';}
});});
