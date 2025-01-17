<?php

namespace UserMeta\WooCommerce;

/**
 * Controller for exporting WooCommerce fields
 *
 * @since 2.1
 * @author Sourov Amin
 */
class UsersExportController
{

	public function __construct()
	{
		/**
		 * Include WooCommerce fields to user exportable fields list
		 */
		add_filter('user_meta_user_exportable_fields', [
			$this,
			'includeWooCommerceFields'
		]);

		/**
		 * Populate WooCommerce data from field
		 */
		add_filter('user_meta_user_export_pre_field_data', [
			$this,
			'populateWooCommerceData'
		], 10, 3);
	}

	/**
	 * Include WooCommerce fields to user exportable fields list
	 * Use WooCommerce[id] format as field key
	 *
	 * @param array $fields
	 * @return array
	 */
	public function includeWooCommerceFields(array $fields)
	{
		foreach ((new WooFields())->getFields() as $key => $label) {
			$fields[$key] = $label;
		}

		return $fields;
	}

	/**
	 * Populate WooCommerce data from field
	 *
	 * @param mixed $fieldValue
	 * @param string $key
	 * @param int $userID
	 * @return mixed
	 */
	public function populateWooCommerceData($fieldValue, $metaKey, $userID)
	{
		if (empty($fieldValue)) {
			$fieldValue = (new WooFields())->getFieldData($userID, $metaKey);
		}

		return $fieldValue;
	}
}