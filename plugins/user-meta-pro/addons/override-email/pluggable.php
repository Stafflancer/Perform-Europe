<?php
use UserMeta\OverrideEmail\Base;

$data = Base::getData();

if (! function_exists('wp_new_user_notification')) :
    
    /**
     * Check if override is set, call UMP emails else wp default
     */
    if (! empty($data['override_registration_email'])) {

        function wp_new_user_notification($user_id, $plaintext_pass = '')
        {
            global $userMeta;
            $user = new WP_User($user_id);
            $user->password = $plaintext_pass;
            $userMeta->prepareEmail('registration', $user);
        }
    }
endif;

if (! function_exists('wp_password_change_notification')) :
    
    /**
     * Check if override is set, call UMP emails else wp default
     */
    if (! empty($data['override_resetpass_email'])) {

        /**
         * Notify the blog admin of a user changing password, normally via email.
         */
        function wp_password_change_notification($user)
        {
            global $userMeta;
            $userMeta->prepareEmail('reset_password', $user);
        }
    }
endif;