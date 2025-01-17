<?php
namespace UserMeta;

/**
 * Addons functionality
 *
 * @since 1.4
 */
class Addons
{

    /**
     * List of activeable addons after running the filter hook.
     *
     * @var array
     */
    private static $addonsList = [];

    /**
     * List of built-in addons.
     *
     * @var array
     */
    private static $builtinAddons = [
        'user-list' => [
            'title' => 'User Listing',
            'brief' => 'Display customized users list both in the front and the backend including access to the user public profile',
            'url' => 'https://user-meta.com/add-ons/user-listing/',
            'icon' => 'fa-list-alt',
            'has_option' => true
        ],
        'woocommerce' => [
            'title' => 'WooCommerce Integration',
            'brief' => 'Integrate UMP\'s shared fields with WooCommere and export data.',
            'url' => 'https://user-meta.com/add-ons/woocommerce/',
            'icon' => 'fa-shopping-cart',
            'has_option' => true
        ],
        'mailchimp' => [
            'title' => 'MailChimp Integration',
            'brief' => 'Integrate with MailChimp and subscribe users to mailing lists upon registration.',
            'url' => 'https://user-meta.com/add-ons/mailchimp/',
            'icon' => 'fa-mail-bulk',
            'has_option' => true
        ],
        'wpml' => [
            'title' => 'WPML Integration',
            'brief' => 'Integration WPML to translate plugin\'s text.',
            'url' => 'https://user-meta.com/add-ons/wpml/',
            'icon' => 'fa-language'
        ],
        'buddypress' => [
            'title' => 'BuddyPress xProfile Export',
            'brief' => 'Export BuddyPress xProfile data with User Meta Pro\'s users export tool.',
            'url' => 'https://user-meta.com/add-ons/buddypress/',
            'icon' => 'fa-users'
        ],
        'hookswitch' => [
            'title' => 'Switch filter or action hooks',
            'brief' => 'Allows integration or avoid plugin conflict by toggling filter or action hooks.',
            'url' => 'https://user-meta.com/add-ons/hookswitch/',
            'icon' => 'fa-toggle-on',
            'has_option' => true
        ],
        'override-email' => [
            'title' => 'Override default WP emails',
            'brief' => 'Override default WordPress emails with User Meta Pro generated emails.',
            'url' => 'https://user-meta.com/add-ons/override-email/',
            'icon' => 'fa-envelope',
            'has_option' => true
        ],
        'edit-default-form' => [
            'title' => 'Personalize default User Meta forms',
            'brief' => 'Personalize default User Meta login, lost password and reset password form.',
            'url' => 'https://user-meta.com/add-ons/edit-default-form/',
            'icon' => 'fa-edit',
            'has_option' => true
        ],
        'restrict-content' => [
            'title' => 'Restrict Content',
            'brief' => 'Hide/Display contents based on user status (restriction rules in page/post editor)',
            'url' => 'https://user-meta.com/add-ons/restrict-content/',
            'icon' => 'fa-ban',
            'has_option' => true
        ],
        'author-box' => [
            'title' => 'Author Box',
            'brief' => 'Display author box with author data fields in posts',
            'url' => 'https://user-meta.com/add-ons/author-box/',
            'icon' => 'fa-list-alt',
            'has_option' => true
        ],
        'nextend-social-login' => [
            'title' => 'Nextend Social Login Integration',
            'brief' => 'Include Nextend social login in User Meta Pro forms',
            'url' => 'https://user-meta.com/add-ons/nextend-social-login/',
            'icon' => 'fa-user-lock',
            'has_option' => true
        ],
        'sample' => [
            'title' => 'Sample Addon',
            'brief' => 'A sample addon for showcase',
            'url' => 'https://user-meta.com/add-ons/',
            'icon' => 'fa-plug',
            'has_option' => true,
            'disabled' => true
        ]
    ];

    /**
     * Get builtin-addons
     *
     * @return array
     */
    private function getBuiltinAddonsList()
    {
        /**
         * Filter out 'disabled' add-ons.
         */
        foreach (self::$builtinAddons as $name => $attr) {
            if (! empty($attr['disabled'])) {
                unset(self::$builtinAddons[$name]);
            }
        }

        return self::$builtinAddons;
    }

    /**
     * Get external addons.
     * If an addin is alredy exists as a built-in addon, it will not included as an external addon.
     *
     * @return array
     */
    private function getExternalAddonsList()
    {
        /**
         * Apply filters to enable external add-ons.
         *
         * @since 2.4
         */
        $externalAddons = apply_filters('user_meta_external_addons_list', []);
        foreach ($externalAddons as $name => $attr) {
            if (in_array($name, array_keys(self::$builtinAddons))) {
                unset($externalAddons[$name]);
            }
        }

        return $externalAddons;
    }

    /**
     * Get combind array of addons from built-in and external addons. Built-in addons has higher priority.
     * $this->getExternalAddonsList() method removes duplicate keys to make sure builtInAddons has higher priority.
     *
     * @return array
     */
    private function getAddonsList()
    {
        if (empty(self::$addonsList)) {
            self::$addonsList = array_merge($this->getBuiltinAddonsList(), $this->getExternalAddonsList());
        }

        return self::$addonsList;
    }

    /**
     * Get addons active/inactive boolean state
     *
     * @return array|null
     */
    private function getAddonsState()
    {
        global $userMeta;
        return $userMeta->getData('addons_state');
    }

    /**
     * Update addon active/inactive boolean state
     * Run action hook on addon activation/deactivation (e.g user_meta_addon_activate_wpml)
     *
     * @uses AddonsController::ajaxToggleAddon()
     *      
     * @param string $name
     * @param boolean $isActive
     */
    public function updateAddonState($name, $isActive)
    {
        global $userMeta;
        $addonsList = $this->getAddonsList();
        if (! isset($addonsList[$name]))
            return false;

        $attr = $addonsList[$name];
        $addonsState = $this->getAddonsState();
        $addonsState[$name] = $isActive ? 1 : 0;

        $result = $userMeta->updateData('addons_state', $addonsState);
        if ($result) {
            if ($isActive)
                $this->loadSingleAddon($name, $attr);
            $actionName = sprintf('user_meta_addon_%s_%s', $isActive ? 'activate' : 'deactivate', $name);
            do_action($actionName);
        }

        return $result;
    }

    /**
     * Route save method to addon using action hook
     *
     * @uses AddonsController::ajaxSaveData()
     */
    public function routeSaveAction()
    {
        do_action('user_meta_addon_save_data_' . filter_input(INPUT_POST, 'addon_name'));
        echo 1;
    }

    /**
     * Load active built-in addons.
     *
     * @uses AddonsController::loadBuiltinAddons()
     */
    public function loadBuiltinAddons()
    {
        $addonsState = $this->getAddonsState();
        foreach ($this->getBuiltinAddonsList() as $name => $attr) {
            if (empty($addonsState[$name]))
                continue;

            $this->loadSingleAddon($name, $attr);
        }
    }

    /**
     * Load active external addons.
     *
     * @uses AddonsController::loadExternalAddons()
     */
    public function loadExternalAddons()
    {
        $addonsState = $this->getAddonsState();
        foreach ($this->getExternalAddonsList() as $name => $attr) {
            if (empty($addonsState[$name]))
                continue;

            $this->loadSingleAddon($name, $attr);
        }
    }

    /**
     * Load single addon and handle exception
     *
     * @param string $name
     *            Addon name
     */
    private function loadSingleAddon($name, $attr)
    {
        global $userMeta;
        if (! empty($attr['init_script'])) {
            $initScriptPath = $attr['init_script'];
        } else {
            $initScriptPath = $userMeta->pluginPath . "/addons/$name/$name.php";
        }
        if (! file_exists($initScriptPath))
            return;

        echoThrowable(function ($initScriptPath) {
            require_once $initScriptPath;
        }, [
            $initScriptPath
        ]);
    }

    /**
     * Show all addons on admin screen
     *
     * @uses views/pro/addons/addonsPage.php
     */
    public function showAddons()
    {
        $addonsState = $this->getAddonsState();
        foreach ($this->getAddonsList() as $name => $attr) {
            $attr['active'] = ! empty($addonsState[$name]) ? true : false;
            echoThrowable(function ($name, $attr) {
                $this->addonPanel($name, $attr);
            }, [
                $name,
                $attr
            ]);
        }
    }

    /**
     * Panel for single addon on admin screen
     *
     * @param string $name
     * @param array $attr
     */
    private function addonPanel($name, array $attr)
    {
        global $userMeta;
        $ajaxData = (new RouteResponse())->prepareRequest('toggle_addon', [
            'addon_name' => $name
        ]);

        $userMeta->renderPro("panel", [
            'name' => $name,
            'title' => $attr['title'],
            'brief' => $attr['brief'],
            'active' => $attr['active'],
            'icon' => ! empty($attr['icon']) ? $attr['icon'] : 'fa-plug',
            'url' => $attr['url'],
            'hasOption' => ! empty($attr['has_option']) ? true : false,
            'ajaxData' => $ajaxData
        ], "addons");

        if (! empty($attr['has_option'])) {
            $this->addonModal($name, $attr);
        }
    }

    /**
     * Generate addon modal
     * Use user_meta_addon_modal_body_%addon_name% action hook for building body
     *
     * @param string $name
     * @param array $attr
     */
    private function addonModal($name, array $attr)
    {
        global $userMeta;
        $ajaxData = (new RouteResponse())->prepareRequest('save_addon_data', [
            'addon_name' => $name
        ]);
        $body = apply_filters("user_meta_addon_modal_body_{$name}", null);

        $userMeta->renderPro("modal", [
            'name' => $name,
            'title' => $attr['title'],
            'icon' => ! empty($attr['icon']) ? $attr['icon'] : 'fa-plug',
            'body' => $body,
            'ajaxData' => $ajaxData
        ], "addons");
    }

    /**
     * Showing stale plugins(addon) on admin notice
     *
     * @uses AddonsController::showStaleAddons()
     */
    public function showStaleAddons()
    {
        $stalePlugins = [
            'user-meta-advanced',
            'user-meta-wpml'
        ];
        $plugins = get_option('active_plugins');
        foreach ($plugins as $plugin) {
            if (in_array(dirname($plugin), $stalePlugins))
                $this->singleStaleAddonNotice(dirname($plugin));
        }
    }

    /**
     * Showing single stale plugin(addon) on admin notice
     */
    private function singleStaleAddonNotice($name)
    {
        $addonsList = $this->getAddonsList();
        switch ($name) {
            case 'user-meta-advanced':
                $recomanded = sprintf("%s, %s, %s", $addonsList['hookswitch']['title'], $addonsList['override-email']['title'], $addonsList['edit-default-form']['title']);
                break;
            case 'user-meta-wpml':
                $recomanded = $addonsList['wpml']['title'];
                break;
        }

        $recomanded = "<strong>$recomanded</strong>";
        $message = sprintf('Using <strong>%s</strong> plugin is depreciated. Please deactivate the plugin from <a href="%s">plugins</a> page and use %s <a href="%s">add-on(s)</a> instead.', ucwords(str_replace('-', ' ', $name)), admin_url('plugins.php'), $recomanded, admin_url('admin.php?page=user-meta-addons'));
        echo adminNotice($message);
    }
}
