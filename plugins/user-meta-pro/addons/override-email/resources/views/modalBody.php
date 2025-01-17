<?php
global $userMeta;
echo '<h4>Override email notifications</h4>';

echo $userMeta->createInput('override_registration_email', 'checkbox', [
    'label' => __('Override default user registration email.', $userMeta->name),
    'value' => ! empty($data['override_registration_email']) ? true : false,
    'id' => 'um_integration_override_registration_email',
    'enclose' => 'p'
]);

echo $userMeta->createInput('override_resetpass_email', 'checkbox', [
    'label' => __('Override default reset password email.', $userMeta->name),
    'value' => ! empty($data['override_resetpass_email']) ? true : false,
    'id' => 'um_integration_override_resetpass_email',
    'enclose' => 'p'
]);
?>

<p>Enable those checkboxes to override default WordPress emails with
	User Meta Pro generated emails. This could be useful, when you need
	registration form other than us but custom email notification by UMP.</p>
