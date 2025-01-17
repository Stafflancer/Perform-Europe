<?php

namespace UserMeta\WooCommerce;

/**
 * Controller for adding Ump fields into WooCommerce registration form
 *
 * @since 2.1
 * @author Sourov Amin
 */
class RegistrationFormController
{

	public function __construct()
	{
		add_action('woocommerce_register_form', [
			$this,
			'fieldsToWcRegistrationForm'
		], 10);

		add_action('woocommerce_created_customer', [
			$this,
			'saveRegistrationFieldsData'
		], 10);

		add_action('woocommerce_registration_errors', [
			$this,
			'registrationFieldsValidation'
		], 10, 1);
	}

	/*
	 * Display added fields in front-end
	 */
	public function fieldsToWcRegistrationForm()
	{
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
	 * Get selected fields data
	 */
	private function getFieldsData()
	{
		global $userMeta;
		$fieldsAvailable = $userMeta->getData('fields');
		$data = Base::getData();
		$acFields = !empty($data['wc_registration_fileds']) ? $data['wc_registration_fileds'] : [];

		return (new UmpFields())->getFormattedFields($fieldsAvailable, $acFields);
	}

	/*
	 * Validate fields input
	 */
	public function registrationFieldsValidation($errors)
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
	 * Save WooCommerce Registration Ump fields data into database
	 */
	public function saveRegistrationFieldsData($customer_id)
	{
		$data = $this->getFieldsData();

		foreach ($data as $key => $val) {
			$metaKey = !empty($val['meta_key']) ? sanitize_key($val['meta_key']) : sanitize_key($val['field_type']);
			$value = sanitize_text_field($_POST[$metaKey]);
			if (!empty($value)) {
				update_user_meta($customer_id, $metaKey, $value);
			}
		}

	}

}