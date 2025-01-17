<?php

namespace UserMeta\WooCommerce;

/**
 * Controller for adding Ump fields into WooCommerce account details
 *
 * @since 2.1
 * @author Sourov Amin
 */
class AccountDetailsController
{

	public function __construct()
	{
		add_action('woocommerce_edit_account_form', [
			$this,
			'frontEndFieldsToWC'
		], 10);

		add_action('woocommerce_save_account_details', [
			$this,
			'saveFieldsData'
		], 10);

		add_action('woocommerce_save_account_details_errors', [
			$this,
			'fieldsValidation'
		], 10, 1);
	}

	/*
	 * Return current user ID
	 */
	private function getUserID()
	{
		return get_current_user_id();
	}

	/*
	 * Display added fields in front-end
	 */
	public function frontEndFieldsToWC()
	{
		$user_id = $this->getUserID();
		if ($user_id == 0) {
			return;
		}
		/*
		 * Display fields in Ump format
		 * Done with Ump single field shortcode
		 */
		$data = $this->getFieldsData();
		foreach ($data as $key => $val) {
			echo do_shortcode('[user-meta-field id=' . $key . ']');
			echo '<style>#um_field_' . $key . '_shortcode_label{font-weight: normal;}</style>';
		}
	}

	/*
	 * Validate fields input
	 */
	public function fieldsValidation($errors)
	{
		$data = $this->getFieldsData();
		foreach ($data as $key => $val) {
			$metaKey = !empty($val['meta_key']) ? $val['meta_key'] : $val['field_type'];
			$fieldTitle = !empty($val['field_title']) ? $val['field_title'] : '';
			$required = !empty($val['required']) ? true : false;

			if ($required) {
				if (empty($_POST[$metaKey])) {
					$message = sprintf(__('%s is a required field.', 'woocommerce'),
						'<strong>' . $fieldTitle . '</strong>');
					$errors->add($metaKey, $message);
				}
			}
		}
		return $errors;
	}

	/*
	 * Get selected fields data
	 */
	private function getFieldsData()
	{
		global $userMeta;
		$fieldsAvailable = $userMeta->getData('fields');
		$data = Base::getData();
		$acFields = !empty($data['wc_account_fileds']) ? $data['wc_account_fileds'] : [];

		return (new UmpFields())->getFormattedFields($fieldsAvailable, $acFields);
	}

	/*
	 * Save WooCommerce Ump fields data into database
	 */
	public function saveFieldsData()
	{
		$user_id = $this->getUserID();
		if ($user_id == 0) {
			return;
		}
		$data = $this->getFieldsData();

		foreach ($data as $key => $val) {
			$metaKey = !empty($val['meta_key']) ? sanitize_key($val['meta_key']) : sanitize_key($val['field_type']);
			$value = sanitize_text_field($_POST[$metaKey]);
			if (!empty($value) || isset($value)) {
				update_user_meta($user_id, $metaKey, $value);
			}
		}
	}

}