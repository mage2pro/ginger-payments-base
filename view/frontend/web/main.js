// 2017-03-02
// @see https://github.com/mage2pro/ginger-payments/blob/0.0.6/view/frontend/web/main.js
// @see https://github.com/mage2pro/kassa-compleet/blob/0.1.1/view/frontend/web/main.js
define([
	'df', 'df-lodash', 'Df_Payment/withOptions', 'jquery', 'ko'
], function(df, _, parent, $, ko) {'use strict'; return parent.extend({
	// 2017-03-02
	// @used-by mage2pro/core/Payment/view/frontend/web/template/item.html
	defaults: {df: {formTemplate: 'Df_GingerPaymentsBase/form'}, idealBank: ''},
	/**
	 * 2016-08-08
	 * 2017-03-01
	 * Задаёт набор передаваемых на сервер при нажатии кнопки «Place Order» данных.
	 * @override
	 * @see mage2pro/core/Payment/view/frontend/web/mixin.js::dfData()
	 * @used-by mage2pro/core/Payment/view/frontend/web/mixin.js::getData()
	 * https://github.com/mage2pro/core/blob/2.0.21/Payment/view/frontend/web/mixin.js?ts=4#L208-L225
	 * @see \Dfe\AllPay\Method::II_OPTION
	 * https://github.com/mage2pro/allpay/blob/1.1.32/Method.php?ts=4#L126
	 * @returns {Object}
	 */
	dfData: function() {return df.o.merge(this._super(), df.clean({
		bank: this.idealSelected() ? this.idealBank : null
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
	 * @used-by Df_GingerPaymentsBase/form
	 * https://github.com/mage2pro/ginger-payments-base/blob/0.1.5/view/frontend/web/template/form.html?ts=4#L7
	 * @returns {Object}[]
	 */
	idealBanks: function () {
		/** @type {Boolean} */
		var t = this.isTest();
		/** @type {Object} */
		var tm = {INGBNL2A: 'ING Bank', RABONL2U: 'Rabobank'};
		return $.map(this.config('idealBanks'), function(v, k) {return {
			label: t && tm[k] ? tm[k] : v, value: k
		};});
	},
 	/**
	 * 2017-03-05
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
	optionAfter: function(v) {return 'ideal' !== v ? this._super(v) : 'Df_GingerPaymentsBase/idealBank';}
});});
