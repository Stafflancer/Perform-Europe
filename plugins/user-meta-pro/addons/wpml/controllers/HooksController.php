<?php
namespace UserMeta\Wpml2;

/**
 *
 * @author Khaled Hossain
 *        
 * @since 1.4
 */
class HooksController
{

    function __construct()
    {
        add_action('user_meta_addon_activate_' . Base::addonData('name'), [
            $this,
            'writeWpmlConfigXml'
        ]);
        add_action('update_option_user_meta_fields', [
            $this,
            'writeWpmlConfigXml'
        ]);
        add_action('update_option_user_meta_forms', [
            $this,
            'writeWpmlConfigXml'
        ]);
        add_action('update_option_user_meta_emails', [
            $this,
            'writeWpmlConfigXml'
        ]);
        add_action('user_meta_after_version_update', [
            $this,
            'writeWpmlConfigXml'
        ]);
        add_filter('user_meta_get_option_settings', [
            $this,
            'translateSettings'
        ]);
        add_action('user_meta_admin_notices', [
            $this,
            'showNotice'
        ]);
    }

    public function writeWpmlConfigXml()
    {
        (new WpmlConfigXml())->writeToFile();
    }

    public function translateSettings($settings)
    {
        return (new Translate())->translateSettings($settings);
    }

    public function showNotice()
    {
        global $userMeta;
        if (! is_writable($userMeta->pluginPath)) {
            echo \UserMeta\adminNotice("To generate <strong>wpml-config.xml</strong>, 
                directory <em>{$userMeta->pluginPath}</em> should be writable by web server.");
        }
    }
}