<?php

namespace UserMeta\RestrictContent;

use UserMeta\Html\Html;

?>

<div class="um_restrict_content_display_field">
	<?php echo Html::select(!empty($valueDisplay) ? esc_attr($valueDisplay) : 'all', [
		'name' => 'um_restrict_content_display',
		'enclose' => 'p',
		'label' => __('Display Contents To', 'user-meta'),
		'onchange' => 'umHideShowRestrictField()'
	], $choice); ?>
</div>

<div class="um_restrict_content_roles_field">
    <br>
	<?php echo Html::multiselect(!empty($valueRoles) ? array_map('esc_attr', $valueRoles) : [], [
		'name' => 'um_restrict_content_roles[]',
		'class' => 'um_restrict_content_field',
		'enclose' => 'p',
		'label' => __('Hide Contents From', 'user-meta'),
	], $allRoles); ?>
</div>
