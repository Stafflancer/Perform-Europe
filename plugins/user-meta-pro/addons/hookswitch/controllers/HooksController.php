<?php
namespace UserMeta\HookSwitch;

/**
 *
 * @author Khaled Hossain
 *        
 * @since 1.4
 */
class HooksController
{

    public function __construct()
    {
        add_action('user_meta_addon_modal_body_' . Base::name(), [
            $this,
            'modalBody'
        ]);

        add_action('user_meta_addon_save_data_' . Base::name(), [
            $this,
            'saveData'
        ]);

        add_filter('user_meta_wp_hooks', [
            $this,
            'modifiedHooks'
        ]);

        /**
         * This hook is deprecated.
         * We are using this hook to prevent user-meta-advance addon's
         * similar hook. user-meta-advance uses different option_key to store hooks status.
         *
         * Without adding this filter, settings of user-meta-advance will override hookswicth settings.
         * This add_filter can removed when all no user uses user-meta-advance addon.
         *
         * 20 for put heigher priority than depreciated user-meta-advance plugin
         */
        add_filter('user_meta_wp_hook', [
            $this,
            'toggleWpHooks'
        ], 20, 2);
    }

    /**
     * Group hook by label
     *
     * @return array
     */
    private function hooksGroup()
    {
        global $userMeta;
        $hooksList = $userMeta->hooksList();
        $group = [];
        foreach ($hooksList as $key => $val) {
            if (strpos($key, '_group_') !== false) {
                $newKey = $val;
                continue;
            }

            if (! empty($newKey))
                $group[$newKey][$key] = $key;
        }

        return $group;
    }

    public function modalBody()
    {
        return Base::view('modalBody', [
            'data' => Base::getData(),
            'hooks' => $this->hooksGroup()
        ]);
    }

    /**
     * Store array of activated hook names
     */
    public function saveData()
    {
        Base::updateData(Base::filterData(\UserMeta\sanitizeDeep($_POST), [
            'active_hooks'
        ]));
    }

    /**
     * Update provided hooks with active_hooks
     *
     * @param array $hooks
     * @return array
     */
    public function modifiedHooks($hooks)
    {
        $data = Base::getData();
        if (! \UserMeta\isValuedArray('active_hooks', $data))
            return $hooks;

        foreach ($data['active_hooks'] as $hookName)
            $hooks[$hookName] = true;

        return $hooks;
    }

    /**
     *
     * @deprecated Still using to override user-meta-advance addon settings
     *            
     * @param boolean $state
     * @param string $hookName
     * @return boolean
     */
    public function toggleWpHooks($state, $hookName)
    {
        $data = Base::getData();
        if (empty($data['active_hooks']))
            return $state;

        return in_array($hookName, $data['active_hooks']) ? true : false;
    }
}