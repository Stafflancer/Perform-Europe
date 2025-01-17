<?php
namespace UserMeta;

class SettingsController
{

    function __construct()
    {
        add_action('wp_ajax_um_update_settings', array(
            $this,
            'ajaxUpdateSettings'
        ));
    }

    function ajaxUpdateSettings()
    {
        global $userMeta;
        $userMeta->verifyNonce(true);

        if ((! empty($_REQUEST['action_type']) ? $_REQUEST['action_type'] : null) == 'authorize_pro') {
            $userMeta->updateProAccountSettings($_REQUEST);
            die();
        }

        $settings = $userMeta->arrayRemoveEmptyValue((! empty($_REQUEST) ? $_REQUEST : null));
        //@todo use sanitizeDeep
        //$settings = $userMeta->arrayRemoveEmptyValue(sanitizeDeep($_REQUEST));

        $extraFieldCount = ! empty($settings['backend_profile']['field_count']) ? $settings['backend_profile']['field_count'] : null;
        $extraFields = ! empty($settings['backend_profile']['fields']) ? $settings['backend_profile']['fields'] : null;

        if (is_array($extraFields)) {
            foreach ($extraFields as $key => $val) {
                if ($key >= $extraFieldCount)
                    unset($settings['backend_profile']['fields'][$key]);
            }
        }

        unset($settings['action']);
        unset($settings['pf_nonce']);
        unset($settings['is_ajax']);
        unset($settings['backend_profile']['field_count']);

        $settings = apply_filters('user_meta_pre_configuration_update', $settings, 'settings');

        $userMeta->updateData('settings', $settings);

        echo $userMeta->showMessage(__('Settings successfully saved.', $userMeta->name));
        die();
    }
}