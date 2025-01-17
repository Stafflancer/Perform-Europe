<?php

namespace UserMeta\NextendSocialLogin;

use UserMeta\Html\Html;

?>

<div>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" id="um_addon_nextend_login_choose_field">
			<br>
			<label for='um_addon_nextend_login_default'>
				<?php echo Html::checkbox(!empty($data['login_form']) ? true : false, [
					'name' => 'login_form',
					'id' => 'um_addon_nextend_login_default'
				]); ?>
				<?php echo __('Enable Nextend Social Login on Default User Meta Login Form', 'user-meta'); ?>
			</label>
			
			<br>
			<br>
			<label>
				<?php echo __('Nextend Social Login on User Meta Form(s)', 'user-meta') ?>
				<?php echo Html::multiselect(!empty($data['registration_form']) ? $data['registration_form'] : [], [
				'name' => 'registration_form[]',
				'class' => 'um_addon_nextend_social_login_form',
				'enclose' => 'div'
			], $form); ?>
			</label>
		</div>
		
			<br>

		<div>
			<?php echo __('For more information about Nextend Login visit:', 'user-meta'); ?>
            <a href="https://nextendweb.com"> www.nextendweb.com</a>
		</div>
		<br>
	</div>

	<script>
		jQuery(function() {
			jQuery('.um_addon_nextend_social_login_form').multiselect({
				includeSelectAllOption: true,
				enableClickableOptGroups: true
			});
		});
	</script>