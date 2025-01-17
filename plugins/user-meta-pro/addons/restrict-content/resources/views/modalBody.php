<?php

namespace UserMeta\RestrictContent;

use UserMeta\Html\Html;

?>

<br>
<p>
    <label for='um_addon_es_show_login_form'>
		<?php echo Html::checkbox(!empty($data['show_login_form']) ? true : false, [
			'name' => 'show_login_form',
			'id' => 'um_addon_es_show_login_form'
		]); ?>
		<?php echo __('Show User Meta Login Form In Appropriate Places', 'user-meta'); ?>
    </label>
    <br>
	<?php echo __('(Display the form when login is needed to access content)', 'user-meta'); ?>
</br>

<p>
    <label class='pf_label'> <?php echo __('Access Denied Text', 'user-meta') ?></label></p>
<?php echo Html::textarea(!empty($data['access_denied_text']) ? $data['access_denied_text'] :
	__('You don\'t have permission to access this content!', 'user-meta'), [
	'name' => 'access_denied_text',
	'placeholder' => __('You don\'t have permission to access this content!', 'user-meta'),
	'style' => 'width:300px;height:50px;',
]); ?>
</p>

<p><label class='pf_label'> <?php echo __('Only For Logged In User Text', 'user-meta') ?></label>
	<?php echo Html::textarea(!empty($data['loggedin_must_text']) ? $data['loggedin_must_text'] :
		__('You must be logged in to view this content!', 'user-meta'), [
		'name' => 'loggedin_must_text',
		'placeholder' => __('You must be logged in to view this content!', 'user-meta'),
		'style' => 'width:300px;height:50px;',
	]); ?>
</p>
