<?php

namespace UserMeta\WooCommerce;

use UserMeta\Html\Html;

global $userMeta;

?>

<br>
<p><label class='pf_label'> <?php echo __('WooCommerce Account Fields', $userMeta->name) ?></label></p>
<?php echo Html::multiselect(!empty($data['wc_account_fileds']) ? $data['wc_account_fileds'] : [], [
	'name' => 'wc_account_fileds[]',
	'class' => 'um_addon_woocommerce_multiple',
	'enclose' => 'div'
], $fields); ?>
<p><?php echo __('Add User Meta shared Fields to WooCommerce Account Details Page.', $userMeta->name); ?></p>
