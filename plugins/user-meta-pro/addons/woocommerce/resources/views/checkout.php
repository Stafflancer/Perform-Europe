<?php

namespace UserMeta\WooCommerce;

use UserMeta\Html\Html;

global $userMeta;

?>

<br>
<p><label class='pf_label'> <?php echo __('WooCommerce Checkout Fields (after customer details)',
			$userMeta->name) ?></label></p>
<?php echo Html::multiselect(!empty($data['wc_checkout_details_fileds']) ? $data['wc_checkout_details_fileds'] : [], [
	'name' => 'wc_checkout_details_fileds[]',
	'class' => 'um_addon_woocommerce_multiple',
	'enclose' => 'div'
], $fields); ?>
<p><?php echo __('Add User Meta shared fields after customer details in WooCommerce Checkout Page.', $userMeta->name); ?></p>

<p><label class='pf_label'> <?php echo __('WooCommerce Checkout Fields (before shipping fields)',
			$userMeta->name) ?></label></p>
<?php echo Html::multiselect(!empty($data['wc_checkout_shipping_fileds']) ? $data['wc_checkout_shipping_fileds'] : [], [
	'name' => 'wc_checkout_shipping_fileds[]',
	'class' => 'um_addon_woocommerce_multiple',
	'enclose' => 'div'
], $fields); ?>
<p><?php echo __('Add User Meta shared fields before shipping fields in WooCommerce Checkout Page.', $userMeta->name); ?></p>

<p><label class='pf_label'> <?php echo __('WooCommerce Checkout Fields (before order review)',
			$userMeta->name) ?></label></p>
<?php echo Html::multiselect(!empty($data['wc_checkout_order_fileds']) ? $data['wc_checkout_order_fileds'] : [], [
	'name' => 'wc_checkout_order_fileds[]',
	'class' => 'um_addon_woocommerce_multiple',
	'enclose' => 'div'
], $fields); ?>
<p><?php echo __('Add User Meta shared fields before order review in WooCommerce Checkout Page.', $userMeta->name); ?></p>
