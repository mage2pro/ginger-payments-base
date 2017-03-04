// 2017-03-02
// @see https://github.com/mage2pro/ginger-payments/blob/0.0.6/view/frontend/web/main.js
// @see https://github.com/mage2pro/kassa-compleet/blob/0.1.1/view/frontend/web/main.js
define([
	'df', 'df-lodash', 'Df_Payment/withOptions', 'jquery'
], function(df, _, parent, $) {'use strict'; return parent.extend({
	defaults: {
		df: {
			// 2017-03-02
			// @used-by mage2pro/core/Payment/view/frontend/web/template/item.html
			formTemplate: 'Df_GingerPaymentsBase/form'
		}
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
	 * @returns {Object}[]
	 */
	idealBanks: function () {return [
		{title: 'Bank 1', value: 'bank-1'}
		,{title: 'Bank 2', value: 'bank-2'}
	]},
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
