<?php
global $userMeta;
// Expected: $registration
// field slug: registration

$html = null;
$html = "<br />";
$html .= "<h6>" . __('User Registration Page', $userMeta->name) . " </h6>";
$html .= wp_dropdown_pages(array(
    'name' => 'registration[user_registration_page]',
    'id' => 'um_registration_user_registration_page',
    'class' => 'um_page_dropdown',
    'selected' => ! empty($registration['user_registration_page']) ? $registration['user_registration_page'] : null,
    'echo' => 0,
    'show_option_none' => 'None '
));
$html .= '<a href="#" id="um_registration_user_registration_page_view" class="button-secondary">View Page</a>';

$html .= '<p>Registration page should contain shortcode like: [user-meta-registration form="your_form_name"]</p>';

$html .= $userMeta->renderPro("registrationSettingsPro", array(
    'registration' => $registration
), "settings");
