// 2017-03-02
// @see https://github.com/mage2pro/ginger-payments/blob/0.0.6/view/frontend/web/main.js
// @see https://github.com/mage2pro/kassa-compleet/blob/0.1.1/view/frontend/web/main.js
define([
	'df', 'df-lodash', 'Df_Payment/withOptions', 'jquery'
], function(df, _, parent, $) {'use strict'; return parent.extend({
	defaults: {
		// 2017-03-02
		// @used-by mage2pro/core/Payment/view/frontend/web/template/item.html
		df: {formTemplate: 'Df_GingerPaymentsBase/form'}
		// 2017-03-04
		// @used-by Df_GingerPaymentsBase/form
		// https://github.com/mage2pro/ginger-payments-base/blob/0.1.5/view/frontend/web/template/form.html?ts=4#L11
		,idealBank: ''
	},
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
	optionAfter: function(v) {return 'ideal' !== v ? this._super(v) : 'Df_GingerPaymentsBase/idealBank';},
	/**
	 * 2017-03-02
	 * @override
	 * @see https://github.com/magento/magento2/blob/2.1.0/app/code/Magento/Checkout/view/frontend/web/js/view/payment/default.js#L127-L159
	 * @used-by https://github.com/magento/magento2/blob/2.1.0/lib/web/knockoutjs/knockout.js#L3863
	*/
	placeOrder: function() {
		if (this.validate()) {
			// http://stackoverflow.com/a/8622351
			/** @type {?String} */
			var option = this.dfRadioValue('option');
			if (null !== option) {
				this.option = option;
			}
			this.placeOrderInternal();
		}
	}
});});
