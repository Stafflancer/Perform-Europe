<?php

namespace UserMeta\NextendSocialLogin;

use UserMeta\OptionData;

/**
 * Initial controller for the addon
 *
 * @since 2.5
 * @author Atira Ferdoushi
 */
class InitController
{

    public function __construct()
    {
        /**
         * Build modal body
         */
        add_action('user_meta_addon_modal_body_' . Base::name(), [
            $this,
            'modalBody'
        ]);

        /**
         * Store addon data
         */
        add_action('user_meta_addon_save_data_' . Base::name(), [
            $this,
            'saveData'
        ]);

        /**
         * Add Nexted Social Login after UMP Login Form
         */
        add_filter('user_meta_default_login_form', [
            $this,
            'nextendButtonLogin'
        ]);

        /**
         * Add Nexted Social Login after UMP Registration form
         */
        add_filter('user_meta_form_config', [
            $this,
            'nextendButtonRegistration'
        ]);
    }

    /**
     * Form List function added
     */
    private function formList()
    {
        $forms = OptionData::getForms();

        $form = array();
        foreach ($forms as $key => $val) {
            $form[$key] = $key;
        }

        return $form;
    }

    /**
     * Build modal body
     */
    public function modalBody()
    {
        return Base::view('modalBody', [
            'data' => Base::getData(),
            'form' => $this->formList()
        ]);
    }

    /**
     * Store addon data
     */
    public function saveData()
    {
        Base::updateData(Base::filterData($_POST, [
            'login_form',
            'registration_form',
        ]));
    }

    /**
     * Include Nextend button on UMP Login
     */
    public function nextendButtonLogin($config)
    {
        $data = Base::getData();

        if (class_exists('NextendSocialLogin', false) && $data['login_form']) {
            $html = \NextendSocialLogin::renderButtonsWithContainer();
            if (empty($config['after_button'])) {
                $config['after_button'] = $html;
            } else {
                $config['after_button'] .= $html;
            }
        }

        return $config;
    }

    /**
     * Include Nextend button on UMP Forms
     */
    public function nextendButtonRegistration($form)
    {
        $data = Base::getData();

        if (class_exists('NextendSocialLogin', false) && $data['registration_form'] && !is_user_logged_in()) {
            if (in_array($form['form_key'], $data['registration_form'])) {
                $html = \NextendSocialLogin::renderButtonsWithContainer();
                if (empty($form['form_end'])) {
                    $form['form_end'] = $html;
                } else {
                    $form['form_end'] .= $html;
                }
            }
        }

        return $form;
    }
}
