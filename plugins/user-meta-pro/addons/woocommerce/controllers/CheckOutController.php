<?php

namespace UserMeta\WooCommerce;

/**
 * Controller for adding Ump fields into WooCommerce Checkout Page
 *
 * @since 2.1
 * @author Sourov Amin
 */
class CheckOutController
{

	public function __construct()
	{
		add_action('woocommerce_checkout_after_customer_details', [
			$this,
			'detailsFieldsToWcCheckoutForm'
		], 10);

		add_action('woocommerce_checkout_shipping', [
			$this,
			'shippingFieldsToWcCheckoutForm'
		], 10);

		add_action('woocommerce_checkout_before_order_review', [
			$this,
			'orderFieldsToWcCheckoutForm'
		], 10);

		add_action('woocommerce_checkout_update_order_meta', [
			$this,
			'saveFieldsData'
		], 10, 1);

		add_action('woocommerce_after_checkout_form', [
			$this,
			'jsValidation'
		], 10, 1);

		/*
		 * Woocommerce_after_checkout_validation
		 */
		add_action('woocommerce_checkout_process', [
			$this,
			'fieldsValidation'
		], 10);

		add_action('woocommerce_admin_order_data_after_order_details', [
			$this,
			'adminData'
		], 10, 1);

		add_filter('woocommerce_admin_order_preview_get_order_details', [
			$this,
			'adminOrderPreviewMetaData'
		], 10, 2);

		add_action('woocommerce_admin_order_preview_end', [
			$this,
			'DisplayOrderDataInPreview'
		], 10);
	}

	/*
	 * Get all selected fields data with field key
	 */
	private function getFieldsData($fieldKey)
	{
		global $userMeta;
		$fieldsAvailable = $userMeta->getData('fields');
		$data = Base::getData();
		$acFields = !empty($data[$fieldKey]) ? $data[$fieldKey] : [];

		return (new UmpFields())->getFormattedFields($fieldsAvailable, $acFields);
	}

	/*
	 * Get all selected fields data
	 */
	public function getAllFieldsData()
	{
		$data = [];
		return array_merge($data, $this->getFieldsData('wc_checkout_details_fileds'),
			$this->getFieldsData('wc_checkout_shipping_fileds'),
			$this->getFieldsData('wc_checkout_order_fileds'));
	}

	/*
	* Display fields in Ump format
	* Done with Ump single field shortcode
	*/
	private function FieldsToWcCheckout($fieldKey)
	{
		$data = $this->getFieldsData($fieldKey);
		if (empty($data)) {
			return;
		}

		foreach ($data as $key => $val) {
			echo do_shortcode('[user-meta-field id=' . $key . ']');
			echo '<style>#um_field_' . $key . '_shortcode_label{font-weight: normal;}</style>';
		}
	}

	/*
	 * Display added fields after customer details in front-end
	 */
	public function detailsFieldsToWcCheckoutForm()
	{
		$this->FieldsToWcCheckout('wc_checkout_details_fileds');
	}

	/*
	 * Display added fields before shipping fields in front-end
	 */
	public function shippingFieldsToWcCheckoutForm()
	{
		return $this->FieldsToWcCheckout('wc_checkout_shipping_fileds');
	}

	/*
	 * Display added fields before order review in front-end
	 */
	public function orderFieldsToWcCheckoutForm()
	{
		return $this->FieldsToWcCheckout('wc_checkout_order_fileds');
	}

	/*
	 * JS validation to WooCommerce checkout fields
	 */
	public function jsValidation()
	{
		if (empty($this->getAllFieldsData())) {
			return;
		}
		?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery(".woocommerce-checkout").validationEngine();
                var form = document.getElementsByClassName("woocommerce-checkout");
                form.encoding = 'multipart/form-data';
                form.setAttribute("enctype", "multipart/form-data");
            });
        </script>
		<?php
	}

	/*
	 * Validate fields input
	 */
	public function fieldsValidation()
	{
		$data = $this->getAllFieldsData();
		if (empty($data)) {
			return;
		}

		foreach ($data as $key => $val) {
			$metaKey = !empty($val['meta_key']) ? $val['meta_key'] : $val['field_type'];
			$fieldTitle = !empty($val['field_title']) ? $val['field_title'] : '';
			$required = !empty($val['required']) ? true : false;

			if ($required) {
				if (empty($_POST[$metaKey])) {
					$message = sprintf(__('%s is a required field.', 'woocommerce'),
						'<strong>' . $fieldTitle . '</strong>');
					wc_add_notice($message, 'error');
				}
			}
		}
	}

	/*
	 * Save WooCommerce Ump fields data into database
	 */
	public function saveFieldsData($order_id)
	{
		$data = $this->getAllFieldsData();
		if (empty($data)) {
			return;
		}

		foreach ($data as $key => $val) {
			$metaKey = !empty($val['meta_key']) ? sanitize_key($val['meta_key']) : sanitize_key($val['field_type']);
			$value = sanitize_text_field($_POST[$metaKey]);
			if (!empty($value) || isset($value)) {
				update_post_meta($order_id, $metaKey, $value);
			}
		}
	}

	/*
	 * Display added data in admin order details page
	 */
	public function adminData($order)
	{
		global $userMeta;
		$orderID = $order->get_id();
		$data = $this->getAllFieldsData();
		$html = null;
		if (!empty($this->getAllFieldsData())) {
			$html .= '<div class="order_data_column">';
			$html .= '<h3>' . __('Extra Data', $userMeta->name) . '</h3><br>';
			foreach ($data as $key => $val) {
				$metaKey = !empty($val['meta_key']) ? $val['meta_key'] : $val['field_type'];
				$fieldTitle = !empty($val['field_title']) ? $val['field_title'] : '';
				$value = get_post_meta($orderID, $metaKey, true);
				if (!empty($value)) {
					$html .= '<strong>' . esc_attr($fieldTitle) . ': </strong>' . esc_attr($value);
					$html .= '<br>';
				}
			}
			$html .= '</div>';
		}
		echo $html;
	}

	/*
	 * Format to be passed into order preview
	 */
	public function adminOrderPreviewMetaData($data, $order)
	{
		global $userMeta;
		$fields = $this->getAllFieldsData();
		if (empty($fields)) {
			return $data;
		}
		$data['um_wc_preview_title'] = __('Extra Data', $userMeta->name);

		foreach ($fields as $key => $val) {
			$metaKey = !empty($val['meta_key']) ? $val['meta_key'] : $val['field_type'];
			$fieldTitle = !empty($val['field_title']) ? $val['field_title'] : '';
			$value = $order->get_meta($metaKey);
			if (!empty($value)) {
				$displayValue = esc_attr($fieldTitle . ': ' . $value);
				$data['um_wc_order_data'][$displayValue] = $metaKey;
			}
		}
		return $data;
	}

	/*
	 * Display added data in order preview
	 */
	public function DisplayOrderDataInPreview()
	{
		$html = null;
		if (!empty($this->getAllFieldsData())) {
			$html .= '<div style="padding: 0 1.5em 1.5em 1.5em;">';
			$html .= '<h2>{{data.um_wc_preview_title}}</h2>';
			$html .= '<# for( value in data.um_wc_order_data ) { #>{{value}}<br><# } #>';
			$html .= '</div>';
		}
		echo $html;
	}

}