<?php

namespace UserMeta\WooCommerce;

use UserMeta\Html\Html;

global $userMeta;

?>

<br>
<p><label class='pf_label'> <?php echo __('WooCommerce Registration Fields', $userMeta->name) ?></label></p>
<?php echo Html::multiselect(!empty($data['wc_registration_fileds']) ? $data['wc_registration_fileds'] : [], [
	'name' => 'wc_registration_fileds[]',
	'class' => 'um_addon_woocommerce_multiple',
	'enclose' => 'div'
], $fields); ?>
<p><?php echo __('Add User Meta shared Fields to WooCommerce Registration Page.', $userMeta->name); ?></p>
