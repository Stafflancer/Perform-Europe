<?php
namespace UserMeta;

/**
 * Controller for addons
 *
 * @since 1.4
 */
class AddonsController
{

    public function __construct()
    {
        /**
         * Load addons init files.
         * Do not load in init action to avoid side effect
         */
        $this->loadBuiltinAddons();

        /**
         * Load external addons on init hook
         * Otherwise user_meta_external_addons_list filter hooks is not working.
         */
        add_action('init', [
            $this,
            'loadExternalAddons'
        ]);

        /**
         * Showing stale plugins(addon) on admin notice
         */
        add_action('admin_notices', [
            $this,
            'showStaleAddons'
        ]);

        /**
         * Activate/deactivate addon from admin section
         */
        add_action('user_meta_ajax_toggle_addon', [
            $this,
            'ajaxToggleAddon'
        ]);

        /**
         * Store addon data
         */
        add_action('user_meta_ajax_save_addon_data', [
            $this,
            'ajaxSaveData'
        ]);
    }

    /**
     * Load builtin addons init file with exception handling
     */
    public function loadBuiltinAddons()
    {
        echoThrowable(function () {
            (new Addons())->loadBuiltinAddons();
        });
    }

    /**
     * Load external addons init file with exception handling
     */
    public function loadExternalAddons()
    {
        echoThrowable(function () {
            (new Addons())->loadExternalAddons();
        });
    }

    /**
     * Showing stale plugins(addon) on admin notice
     */
    public function showStaleAddons()
    {
        (new Addons())->showStaleAddons();
    }

    /**
     * Toggle addon activation/deactivation
     *
     * @output echo 1 for success
     */
    public function ajaxToggleAddon()
    {
        (new RouteResponse())->verifyAdminNonce();

        $name = filter_input(INPUT_POST, 'addon_name');
        $state = filter_input(INPUT_POST, 'toggle_state');

        echo (new Addons())->updateAddonState($name, $state);
    }

    /**
     * Route to action hook for storing addon data
     */
    public function ajaxSaveData()
    {
        (new RouteResponse())->verifyAdminNonce();
        (new Addons())->routeSaveAction();
    }
}

