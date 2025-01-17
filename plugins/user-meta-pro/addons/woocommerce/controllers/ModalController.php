<?php

namespace UserMeta\WooCommerce;

/**
 * Initial controller for the addon
 *
 * @since 2.1
 * @author Khaled Hossain
 */
class ModalController
{

	public function __construct()
	{
		/**
		 * Build modal body
		 */
		add_action('user_meta_addon_modal_body_' . Base::name(), [
			$this,
			'modalBody'
		]);

		/**
		 * Store addon data
		 */
		add_action('user_meta_addon_save_data_' . Base::name(), [
			$this,
			'saveData'
		]);
	}

	/**
	 * Build modal body
	 */
	public function modalBody()
	{
		return Base::view('modalBody', [
			'data' => Base::getData(),
			'fields' => (new UmpFields())->availableUmpFields()
		]);
	}

	/**
	 * Store addon data
	 */
	public function saveData()
	{
		Base::updateData(Base::filterData(\UserMeta\sanitizeDeep($_POST), [
			'wc_account_fileds',
			'wc_registration_fileds',
			'wc_checkout_details_fileds',
			'wc_checkout_shipping_fileds',
			'wc_checkout_order_fileds'
		]));
	}
}