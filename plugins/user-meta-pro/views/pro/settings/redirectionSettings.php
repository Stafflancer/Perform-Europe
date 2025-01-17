<?php
global $userMeta;
// Expected: $redirection
// field slug: redirection

$roles = $userMeta->getRoleList();

$html = null;
$html = "<br />";
$html .= '<h6>' . __('User Redirection Settings', $userMeta->name) . '</h6>';
$html .= $userMeta->createInput('redirection[disable]', 'checkbox', array(
    'label' => ' ' . __('Disable redirection feature', $userMeta->name),
    'id' => 'um_redirection_disable',
    'value' => ! empty($redirection['disable']) ? $redirection['disable'] : null,
    'enclose' => 'p',
    'style' => 'margin-top:0px;'
));
$html .= "<div class='pf_divider'></div>";

$html .= '<h6>' . __('Set redirection on login, logout and registration', $userMeta->name) . '</h6>';
$html .= "<div id=\"redirection_tabs\">";
$html .= "<ul>";
foreach ($roles as $key => $val)
    $html .= "<li><a href=\"#redirection-tabs-$key\">$val</a></li>";
$html .= "</ul>";

$noMsg = __('No Redirection', $userMeta->name);
$defaultMsg = __('Default (<em>Use default redirection</em>)', $userMeta->name);
$sameUrlMsg = __('Same URL (<em>Same url, that was submitted</em>)', $userMeta->name);
$refererMsg = __('Referer (<em>Send the user back to the page where they come from</em>)', $userMeta->name);
$homeMsg = __('Home', $userMeta->name) . sprintf(" (<em>%s</em>)", site_url());
$profileMsg = __('Profile', $userMeta->name) . sprintf(" (<em>%s</em>)", $userMeta->getProfileLink());
$dashboardMsg = __('Dashboard', $userMeta->name) . sprintf(" (<em>%s</em>)", admin_url());
$loginPageMsg = __('Login Page', $userMeta->name) . sprintf(" (<em>%s</em>)", wp_login_url());
$customUrlMsg = __('<em> (Include http:// with url)</em>', $userMeta->name);

$loginOptions = array(
    'default' => $defaultMsg,
    'same_url' => $sameUrlMsg,
    'referer' => $refererMsg,
    'home' => $homeMsg,
    'profile' => $profileMsg,
    'dashboard' => $dashboardMsg
);

$logoutOptions = array(
    'default' => $defaultMsg,
    'same_url' => $sameUrlMsg,
    'referer' => $refererMsg,
    'home' => $homeMsg,
    'login_page' => $loginPageMsg
);

$registrationOptions = array(
    'default' => $noMsg,
    'referer' => $refererMsg,
    'home' => $homeMsg,
    'profile' => $profileMsg,
    'dashboard' => $dashboardMsg
);

$html2 = null;
foreach ($roles as $key => $val) {
    $content = null;
    
    /**
     * Login redirection
     */
    $extra = [
        'page' => __('Page:', $userMeta->name) . '&nbsp' . wp_dropdown_pages([
            'name' => "redirection[login_page][$key]",
            'selected' => ! empty($redirection['login_page'][$key]) ? $redirection['login_page'][$key] : null,
            'echo' => 0,
            'show_option_none' => __('None', $userMeta->name)
        ]),
        'custom_url' => $userMeta->createInput("redirection[login_url][$key]", 'url', [
            'value' => ! empty($redirection['login_url'][$key]) ? $redirection['login_url'][$key] : '',
            'placeholder' => 'http://example.com',
            'before' => __('Custom url:', $userMeta->name) . '&nbsp',
            'after' => $customUrlMsg,
            'style' => 'width:300px;'
        ])
    ];
    
    // $html .= "<p><strong>". __( 'Login', $userMeta->name ) . "</strong></p>";
    $content .= $userMeta->createInput("redirection[login][$key]", "radio", array(
        "value" => ! empty($redirection['login'][$key]) ? $redirection['login'][$key] : (! empty($redirection['login']['subscriber']) ? $redirection['login']['subscriber'] : null),
        "label" => __('Login Redirection', $userMeta->name),
        "id" => "um_redirection_login_$key",
        "option_before" => "<p class='um_admin_normal_label'>",
        "option_after" => "</p>",
        "by_key" => true,
        "label_class" => "pf_label",
        "enclose" => "div"
    ), array_merge($loginOptions, $extra));
    
    /**
     * Logout redirection
     */
    $extra = [
        'page' => __('Page:', $userMeta->name) . '&nbsp' . wp_dropdown_pages([
            'name' => "redirection[logout_page][$key]",
            'selected' => ! empty($redirection['logout_page'][$key]) ? $redirection['logout_page'][$key] : null,
            'echo' => 0,
            'show_option_none' => __('None', $userMeta->name)
        ]),
        'custom_url' => $userMeta->createInput("redirection[logout_url][$key]", 'url', [
            'value' => ! empty($redirection['logout_url'][$key]) ? $redirection['logout_url'][$key] : '',
            'placeholder' => 'http://example.com',
            'before' => __('Custom url:', $userMeta->name) . '&nbsp',
            'after' => $customUrlMsg,
            'style' => 'width:300px;'
        ])
    ];
    
    $content .= $userMeta->createInput("redirection[logout][$key]", "radio", array(
        "value" => ! empty($redirection['logout'][$key]) ? $redirection['logout'][$key] : (! empty($redirection['logout']['subscriber']) ? $redirection['logout']['subscriber'] : null),
        "label" => __('Logout Redirection ', $userMeta->name),
        "id" => "um_redirection_logout_$key",
        "option_before" => "<p class='um_admin_normal_label'>",
        "option_after" => "</p>",
        "by_key" => true,
        "label_class" => "pf_label",
        "enclose" => "div"
    ), array_merge($logoutOptions, $extra));
    
    /**
     * Registration redirection
     */
    $extra = [
        'page' => __('Page:', $userMeta->name) . '&nbsp' . wp_dropdown_pages([
            'name' => "redirection[registration_page][$key]",
            'selected' => ! empty($redirection['registration_page'][$key]) ? $redirection['registration_page'][$key] : null,
            'echo' => 0,
            'show_option_none' => __('None', $userMeta->name)
        ]),
        'custom_url' => $userMeta->createInput("redirection[registration_url][$key]", 'url', [
            'value' => ! empty($redirection['registration_url'][$key]) ? $redirection['registration_url'][$key] : '',
            'placeholder' => 'http://example.com',
            'before' => __('Custom url:', $userMeta->name) . '&nbsp',
            'after' => $customUrlMsg,
            'style' => 'width:300px;'
        ])
    ];
    
    $content .= $userMeta->createInput("redirection[registration][$key]", "radio", array(
        "value" => ! empty($redirection['registration'][$key]) ? $redirection['registration'][$key] : (! empty($redirection['registration']['subscriber']) ? $redirection['registration']['subscriber'] : null),
        "label" => __('Registration Redirection', $userMeta->name),
        "id" => "um_redirection_registration_$key",
        "option_before" => "<p class='um_admin_normal_label'>",
        "option_after" => "</p>",
        "by_key" => true,
        "label_class" => "pf_label",
        "enclose" => "div"
    ), array_merge($registrationOptions, $extra));
    
    $html .= "<div id=\"redirection-tabs-$key\">$content</div>";
} // End foreach
$html .= "</div>";