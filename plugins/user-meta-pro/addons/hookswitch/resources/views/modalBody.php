<?php
/**
 * Expected $data, $hooks
 */
global $userMeta;

echo $userMeta->createInput('active_hooks', 'multiselect', [
    'id' => 'um_integration_hooks',
    'label' => 'Integrate filter / action hooks',
    'value' => isset($data['active_hooks']) ? $data['active_hooks'] : '',
    'label_class' => 'um_label_top',
    'enclose' => 'div'
], $hooks);
?>

<br />
<div>These hooks will allow others plugins to talk with User Meta Pro.
	Enable them to integrate with others plugin or disable them for
	avoiding plugin conflict.</div>

<script>
jQuery(function() {
    jQuery('#um_integration_hooks').multiselect({
    	includeSelectAllOption: true,
    	enableClickableOptGroups: true
    });
});
</script>