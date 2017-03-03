// 2017-03-02
define([
	'df'
	,'df-lodash'
	,'Df_Core/my/redirectWithPost'
 	,'Df_Payment/custom'
  	,'jquery'
], function(df, _, redirectWithPost, parent, $) {'use strict'; return parent.extend({
	defaults: {
		df: {
			test: {showBackendTitle: false},
			// 2017-03-02
			// @used-by mage2pro/core/Payment/view/frontend/web/template/item.html
			formTemplate: 'Df_GingerPaymentsBase/form'
		}
	},
	/**
	 * 2017-03-02
	 * Задаёт набор передаваемых на сервер при нажатии кнопки «Place Order» данных.
	 * @override
	 * @see mage2pro/core/Payment/view/frontend/web/mixin.js::dfData()
	 * @used-by mage2pro/core/Payment/view/frontend/web/mixin.js::getData()
	 * https://github.com/mage2pro/core/blob/2.0.21/Payment/view/frontend/web/mixin.js?ts=4#L208-L225
	 * @returns {Object}
	 */
	dfData: function() {return df.o.merge(this._super(), df.clean({
		// 2017-03-02
		// @see \Df\GingerPaymentsBase\Method::II_OPTION
		// https://github.com/mage2pro/ginger-payments-base/blob/0.0.5/Method.php?ts=4#L73
		//
		// 2017-03-03
		// If the «iDEAL» payment option is selected,
		// then a value passed to the server should include the chosen iDEAL issuer bank.
		option: this.option
	}));},
	/**
	 * 2017-03-02
	 * @override
	 * @see mage2pro/core/Payment/view/frontend/web/mixin.js
	 * @used-by placeOrderInternal()
	 */
	onSuccess: function(json) {
		/** @type {Object} */
		var data = $.parseJSON(json);
		// 2017-03-02
		// @see \Df\GingerPaymentsBase\Method::getConfigPaymentAction()
		redirectWithPost(data.uri, data.params);
	},
	/**
	 * 2017-03-02
	 * @returns {Object}
	 */
	options: function() {return this.config('options');},
	/**
	 * 2017-03-02
	 * @returns {Object[]}
	 */
	optionsA: df.c(function() {return $.map(this.options(), function(label, v) {return {
		domId: 'df-option-' + v, label: label, value: v
	};});}),
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
