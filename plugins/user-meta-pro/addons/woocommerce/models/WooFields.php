<?php

namespace UserMeta\WooCommerce;

/**
 * All WooCommerce related functions
 *
 * @since 2.1
 * @author Sourov Amin
 */
class WooFields
{

	private function getBillingFields()
	{
		return [
			'billing_first_name' => __('Billing First Name', 'woocommerce'),
			'billing_last_name' => __('Billing Last Name', 'woocommerce'),
			'billing_company' => __('Billing Company Name', 'woocommerce'),
			'billing_country' => __('Billing Country', 'woocommerce'),
			'billing_address_1' => __('Billing Street Address 1', 'woocommerce'),
			'billing_address_2' => __('Billing Street Address 2', 'woocommerce'),
			'billing_city' => __('Billing Town/City', 'woocommerce'),
			'billing_state' => __('Billing District', 'woocommerce'),
			'billing_postcode' => __('Billing Postcode/ZIP', 'woocommerce'),
			'billing_phone' => __('Billing Phone', 'woocommerce'),
			'billing_email' => __('Billing Email address', 'woocommerce')
		];
	}

	private function getShippingFields()
	{
		return [
			'shipping_first_name' => __('Shipping First Name', 'woocommerce'),
			'shipping_last_name' => __('Shipping Last Name', 'woocommerce'),
			'shipping_company' => __('Shipping Company Name', 'woocommerce'),
			'shipping_country' => __('Shipping Country', 'woocommerce'),
			'shipping_address_1' => __('Shipping Street Address 1', 'woocommerce'),
			'shipping_address_2' => __('Shipping Street Address 2', 'woocommerce'),
			'shipping_city' => __('Shipping Town/City', 'woocommerce'),
			'shipping_state' => __('Shipping District', 'woocommerce'),
			'shipping_postcode' => __('Shipping Postcode/ZIP', 'woocommerce')
		];
	}

	/**
	 * Get all WooCommerce fields
	 *
	 * @return array [field_id: [name, group_name]]
	 */
	public function getFields()
	{
		return array_merge($this->getBillingFields(), $this->getShippingFields());
	}

	/**
	 * Get data for target field
	 *
	 * @param int $fieldID
	 * @param int $userID
	 * @return mixed
	 */
	public function getFieldData($userID, $metaKey)
	{
		return get_user_meta($userID, $metaKey, true);
	}
}