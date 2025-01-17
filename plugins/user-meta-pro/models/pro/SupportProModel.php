<?php
namespace UserMeta;

class SupportProModel
{

    function emailVerification($config = array())
    {
        global $userMeta;

        if (empty($config))
            $config = $userMeta->getExecutionPageConfig('email_verification');

        $email = isset($_REQUEST['email']) ? sanitize_email(rawurldecode($_REQUEST['email'])) : '';
        $key = isset($_REQUEST['key']) ? sanitize_text_field(rawurldecode($_REQUEST['key'])) : '';

        if (! $email || ! $key)
            return $userMeta->showError($userMeta->getMsg('invalid_parameter'));

        $user = get_user_by('email', $email);
        if (! $user)
            return $userMeta->showError($userMeta->getMsg('email_not_found'));

        $status = get_user_meta($user->ID, $userMeta->prefixLong . 'user_status', true);

        if ($status == 'active')
            return $userMeta->showMessage($userMeta->getMsg('user_already_activated'));

        $preSavedKey = get_user_meta($user->ID, $userMeta->prefixLong . 'email_verification_code', true);

        if (empty($preSavedKey) && $status == 'pending')
            return $userMeta->showMessage($userMeta->getMsg('email_verified_pending_admin'), 'info');

        $html = null;
        if ($preSavedKey == $key) {
            $registration = $userMeta->getSettings('registration');
            $user_activation = $registration['user_activation'];

            if ($user_activation == 'email_verification')
                $status = 'active';

            update_user_meta($user->ID, $userMeta->prefixLong . 'user_status', $status);
            update_user_meta($user->ID, $userMeta->prefixLong . 'email_verification_code', '');
            do_action('user_meta_email_verified', $user->ID);

            $html .= $userMeta->showMessage($userMeta->getMsg($status == 'active' ? 'email_verified' : 'email_verified_pending_admin', esc_url(wp_login_url())));
            if (! empty($config['redirect']))
                $html .= $userMeta->jsRedirect($config['redirect'], 5);
            return $html;
        } else
            return $userMeta->showError($userMeta->getMsg('invalid_key'));
    }

    /**
     *
     * @param string $user
     * @param mixed $modifiedOldData:
     *            This variable is set on umEmailNotificationController->userModifiedOldData
     * @return string
     */
    function userModifiedData($user, &$modifiedOldData)
    {
        global $userMeta;

        if (! $modifiedOldData || ! is_array($modifiedOldData))
            return;

        /**
         * Use filter: user_meta_user_modified_old_data_tracker to filter tracker
         */
        $modifiedOldData = apply_filters('user_meta_user_modified_old_data', $modifiedOldData, $user);

        $fieldsLabel = array_combine(array_keys($modifiedOldData), array_keys($modifiedOldData));
        $fieldsLabel['um_new_label'] = __('Updated data:', $userMeta->name);
        $fieldsLabel['um_old_label'] = __('Previous data:', $userMeta->name);

        $fieldsLabel = apply_filters('user_meta_user_modified_data_fields_label', $fieldsLabel, $user, $modifiedOldData);

        if (isset($modifiedOldData['user_pass'])) {
            $plainPass = isset($user->password) ? $user->password : '';
            $user->user_pass = apply_filters('user_meta_user_modified_data_plainpass', __('Updated password', $userMeta->name), $plainPass, $user);
        }

        $msg = '';
        $msg .= isset($fieldsLabel['um_new_label']) ? $fieldsLabel['um_new_label'] . "\r\n" : '';
        foreach ($modifiedOldData as $key => $val) {
            $msg .= $fieldsLabel[$key] . ': ';
            $msg .= is_array($user->$key) ? trim(implode(', ', $user->$key)) : trim($user->$key);
            $msg .= "\r\n";
        }

        $msg .= "\r\n";

        $msg .= isset($fieldsLabel['um_old_label']) ? $fieldsLabel['um_old_label'] . "\r\n" : '';
        foreach ($modifiedOldData as $key => $val) {
            if (isset($modifiedOldData['user_pass']))
                continue;

            $msg .= $fieldsLabel[$key] . ': ';
            $msg .= is_array($val) ? implode(',', $val) : trim($val);
            $msg .= "\r\n";
        }

        return $msg;
    }

    function disableAdminRow($id)
    {
        if (in_array($id, array(
            'heading_0',
            'heading_1',
            'heading_2',
            'heading_3'
        ))) {
            ?>
<script type="text/javascript">
                jQuery(document).ready(function(){
                    id = <?php echo str_replace( 'heading_', '', $id ); ?>;
                    jQuery( "h2:eq(" + id + ")" ).hide();
                });
            </script>
<?php
        } elseif (in_array($id, array(
            'color-picker',
            'pass1'
        ))) {
            ?>
<script type="text/javascript">
                jQuery(document).ready(function(){
                    jQuery( "#<?php echo $id; ?>" ).parents( "table" ).hide();
                });
            </script>
<?php
        } else {
            ?>
<script type="text/javascript">
                jQuery(document).ready(function(){
                    jQuery( "#<?php echo $id; ?>" ).parents( "tr" ).hide();
                });
            </script>
<?php
        }
    }

    // TODO: referer
    /**
     * Get redirection url from settings.
     *
     * @param string $redirect_to:
     *            get
     *            $redirect_to from filter.
     * @param string $action:
     *            login,
     *            logout or registration
     * @param string $role:
     *            role
     *            name
     * @return $redirect_to: url
     */
    function getRedirectionUrl($redirect_to, $action, $role = null)
    {
        global $userMeta;

        if (! $role)
            $role = $userMeta->getUserRole(get_current_user_id());

        $redirection = $userMeta->getSettings('redirection');

        if (! empty($redirection['disable']))
            return $redirect_to;

        $redirectionType = ! empty($redirection[$action][$role]) ? $redirection[$action][$role] : null;

        $scheme = is_ssl() ? 'https://' : 'http://';

        if ($redirectionType == 'same_url') {
            if (! empty($_REQUEST['_wp_http_referer']))
                $redirect_to = $scheme . esc_attr($_SERVER['HTTP_HOST']) . esc_attr($_REQUEST['_wp_http_referer']);
            elseif (! empty($_SERVER['REQUEST_URI']))
                $redirect_to = $scheme . esc_attr($_SERVER['HTTP_HOST']) . esc_attr($_SERVER['REQUEST_URI']);
        } elseif ($redirectionType == 'referer') {
            if (! empty($_REQUEST['redirect_to']))
                $redirect_to = esc_attr($_REQUEST['redirect_to']);
            elseif (! empty($_REQUEST['pf_http_referer']))
                $redirect_to = esc_attr($_REQUEST['pf_http_referer']);
            elseif (! empty($_REQUEST['_wp_http_referer']))
                $redirect_to = $scheme . esc_attr($_SERVER['HTTP_HOST']) . esc_attr($_REQUEST['_wp_http_referer']);
            elseif (! empty($_SERVER['HTTP_REFERER']))
                $redirect_to = esc_attr($_SERVER['HTTP_REFERER']);
            elseif (! empty($_SERVER['REQUEST_URI']))
                $redirect_to = $scheme . esc_attr($_SERVER['HTTP_HOST']) . esc_attr($_SERVER['REQUEST_URI']);
        } elseif ($redirectionType == 'home')
            $redirect_to = home_url();
        elseif ($redirectionType == 'profile')
            $redirect_to = $userMeta->getProfileLink();
        elseif ($redirectionType == 'dashboard')
            $redirect_to = admin_url();
        elseif ($redirectionType == 'login_page')
            $redirect_to = wp_login_url();
        elseif ($redirectionType == 'page') {
            if (isset($redirection[$action . '_page'][$role]))
                $redirect_to = get_permalink($redirection[$action . '_page'][$role]);
        } elseif ($redirectionType == 'custom_url') {
            if (isset($redirection[$action . '_url'][$role]))
                $redirect_to = $redirection[$action . '_url'][$role];
        }

        return html_entity_decode($redirect_to);
    }

    /**
     * Generate activation/deactivation link with or without nonce.
     */
    function userActivationUrl($action, $userID, $addNonce = true)
    {
        $url = admin_url('users.php');
        $url = add_query_arg(array(
            'action' => $action,
            'user' => $userID
        ), $url);

        if ($addNonce)
            $url = wp_nonce_url($url, 'um_activation');

        return $url;
    }

    /**
     * Generate activation/deactivation link with or without nonce.
     */
    function emailVerificationUrl($user)
    {
        global $userMeta;

        $settings = $userMeta->getSettings('registration');
        if (empty($settings['email_verification_page']))
            return;

        $pageID = (int) $settings['email_verification_page'];
        $url = get_permalink($pageID);
        if (empty($url))
            return;

        $hash = get_user_meta($user->ID, $userMeta->prefixLong . 'email_verification_code', true);
        if (! $hash) {
            $hash = wp_generate_password(30, false);
            update_user_meta($user->ID, $userMeta->prefixLong . 'email_verification_code', $hash);
        }

        $url = add_query_arg(array(
            'email' => rawurlencode($user->user_email),
            'key' => rawurlencode($hash),
            'action' => 'ev'
        ), $url);

        return htmlspecialchars_decode($url);
    }

    /**
     * Generate role based email template
     *
     * @param $slugs :
     *            array containing two value without keys. e.g array( 'registration', 'user_email' )
     * @param $data :
     *            array containing data to populate
     * @return string html
     */
    function buildRolesEmailTabs($slugs = array(), $data = array())
    {
        global $userMeta;
        $roles = $userMeta->getRoleList();

        foreach ($roles as $key => $val) {
            $forms[$key] = $userMeta->renderPro('singleEmailForm', array(
                'slug' => "{$slugs[0]}[{$slugs[1]}][$key]",
                'from_email' => ! empty($data[$slugs[0]][$slugs[1]][$key]['from_email']) ? $data[$slugs[0]][$slugs[1]][$key]['from_email'] : '',
                'from_name' => ! empty($data[$slugs[0]][$slugs[1]][$key]['from_name']) ? $data[$slugs[0]][$slugs[1]][$key]['from_name'] : '',
                'format' => ! empty($data[$slugs[0]][$slugs[1]][$key]['format']) ? $data[$slugs[0]][$slugs[1]][$key]['format'] : '',
                'subject' => ! empty($data[$slugs[0]][$slugs[1]][$key]['subject']) ? $data[$slugs[0]][$slugs[1]][$key]['subject'] : '',
                'body' => ! empty($data[$slugs[0]][$slugs[1]][$key]['body']) ? $data[$slugs[0]][$slugs[1]][$key]['body'] : ''
                /*
             * 'after_form'=> $userMeta->createInput( null, 'checkbox', array(
             * 'label' => __( 'Copy this form data to all others role', $userMeta->name ),
             * 'enclose' => 'p',
             * 'onclick' => 'copyFormData(this)',
             * 'class' => 'asdf',
             * ) ),
             */
            ), 'email');
        }

        $html = $userMeta->jQueryRolesTab("{$slugs[0]}-{$slugs[1]}", $roles, $forms);

        if ('admin_email' == $slugs[1]) {
            $html .= $userMeta->createInput("{$slugs[0]}[{$slugs[1]}][um_all_admin]", 'checkbox', array(
                'label' => __('Send email to all admin', $userMeta->name),
                'id' => "um_{$slugs[0]}_{$slugs[1]}_um_all_admin",
                'value' => ! empty($data[$slugs[0]][$slugs[1]]['um_all_admin']),
                'enclose' => 'p'
            ));
        }

        if ('profile_update' == $slugs[0]) {
            $html .= $userMeta->createInput("{$slugs[0]}[{$slugs[1]}][on_modify]", 'checkbox', array(
                'label' => __('Send email only, when user\'s data has been modified', $userMeta->name),
                'id' => "um_{$slugs[0]}_{$slugs[1]}_on_modify",
                'value' => ! empty($data[$slugs[0]][$slugs[1]]['on_modify']),
                'enclose' => 'p'
            ));
        }

        $html .= $userMeta->createInput("{$slugs[0]}[{$slugs[1]}][um_disable]", 'checkbox', array(
            'label' => __('Disable this notification', $userMeta->name),
            'id' => "um_{$slugs[0]}_{$slugs[1]}_um_disable",
            'value' => ! empty($data[$slugs[0]][$slugs[1]]['um_disable']),
            'enclose' => 'p'
        ));

        return $html;
    }

    /**
     * Callback hook for "pre_user_query".
     * Filter users by registration date
     */
    function filterRegistrationDate($query)
    {
        global $wpdb;

        if (! empty($_REQUEST['start_date']))
            $query->query_where = $query->query_where . $wpdb->prepare(" AND $wpdb->users.user_registered >= %s", sanitize_text_field($_REQUEST['start_date']));

        if (! empty($_REQUEST['end_date']))
            $query->query_where = $query->query_where . $wpdb->prepare(" AND $wpdb->users.user_registered <= %s", sanitize_text_field($_REQUEST['end_date']));

        return $query;
    }

    function isPro()
    {
        global $userMeta;
        if (! $userMeta->isPro)
            return false;
        return $userMeta->isLicenceValidated() ? true : false;
    }

    function generatePassword(&$user)
    {
        $pass = wp_generate_password();
        wp_set_password($pass, $user->ID);
        return $pass;
    }

    function loadEncDirectory($dir)
    {
        if (! file_exists($dir))
            return;
        foreach (scandir($dir) as $item) {
            if (preg_match("/Encrypted.php$/i", $item)) {
                $codes = file_get_contents($dir . $item);
                $codes = base64_decode($codes);
                eval($codes);
                $className = str_replace("Encrypted.php", "", $item);
                if (class_exists($className))
                    $classes[] = new $className();
            }
        }
        return isset($classes) ? $classes : false;
    }

    function prepareEmail($key, $user, $extra = array())
    {
        global $userMeta;

        $data = $userMeta->getEmailsData($key);
        $role = $userMeta->getUserRole($user->ID);

        if ($key == 'profile_update' && ! empty($data['admin_email']['on_modify']) && ! $extra)
            return;
        if ($key == 'profile_update' && ! empty($data['user_email']['on_modify']) && ! $extra)
            return;

        if (empty($data['admin_email']['um_disable'])) {

            $adminEmails = ! empty($data['admin_email']['um_all_admin']) ? $userMeta->getAllAdminEmail() : get_bloginfo('admin_email');
            $adminEmails = apply_filters('user_meta_admin_email_recipient', $adminEmails, $key, $user, $extra);

            $mailData = ! empty($data['admin_email'][$role]) ? $data['admin_email'][$role] : null;
            $mailData['email'] = $adminEmails;
            $mailData['email_type'] = $key;
            $mailData['receipt_type'] = 'admin';
            $userMeta->sendEmail(self::_prepareEmail($mailData, $user, $extra));
        }

        if (empty($data['user_email']['um_disable'])) {
            $mailData = ! empty($data['user_email'][$role]) ? $data['user_email'][$role] : null;
            $mailData['email'] = $user->user_email;
            $mailData['email_type'] = $key;
            $mailData['receipt_type'] = 'user';
            $userMeta->sendEmail(self::_prepareEmail($mailData, $user, $extra));
        }
    }

    function _prepareEmail($mailData, $user, $extra)
    {
        global $userMeta;

        $mailData = apply_filters('user_meta_raw_email', $mailData, $user, $extra);

        $mailData['subject'] = $userMeta->convertUserContent($user, (! empty($mailData['subject']) ? $mailData['subject'] : null), $extra);
        $mailData['body'] = $userMeta->convertUserContent($user, (! empty($mailData['body']) ? $mailData['body'] : null), $extra);

        return $mailData;
    }
}