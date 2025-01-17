<?php
namespace UserMeta\EditDefaultForm;

/**
 * Initial controller for the addon
 *
 * @since 1.4
 * @author Khaled Hossain
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
         * Modify default loging form
         */
        add_filter('user_meta_default_login_form', [
            $this,
            'hookLoginForm'
        ]);
        
        /**
         * Modify lostpassword or resetpass form
         */
        add_filter('user_meta_execution_page_config', [
            $this,
            'hookLostResetPassFrom'
        ], 10, 2);
    }

    /**
     * Build modal body
     */
    public function modalBody()
    {
        return Base::view('modalBody', [
            'data' => Base::getData()
        ]);
    }

    /**
     * Store addon data
     */
    public function saveData()
    {
        Base::updateData(Base::filterData(\UserMeta\sanitizeDeep($_POST), [
            'login',
            'lostpassword',
            'resetpass'
        ]));
    }

    /**
     * Modify default loging form
     *
     * @param array $configs            
     * @return array
     */
    function hookLoginForm($configs)
    {
        $data = Base::getData();
        if (! empty($data['login']))
            return array_merge($configs, $data['login']);
        
        return $configs;
    }

    /**
     * Modify lostpassword or resetpass form
     *
     * @param array $configs            
     * @param string $key            
     * @return array
     */
    function hookLostResetPassFrom($configs, $key)
    {
        $data = Base::getData();
        if (! empty($data[$key]))
            return array_merge($configs, $data[$key]);
        
        return $configs;
    }
}