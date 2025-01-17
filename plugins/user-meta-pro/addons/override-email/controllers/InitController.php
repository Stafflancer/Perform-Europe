<?php
namespace UserMeta\OverrideEmail;

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
            'override_registration_email',
            'override_resetpass_email'
        ]));
    }
}