<?php
namespace UserMeta\UserList;

/**
 * Initial controller for the addon
 *
 * @since 2.1
 * @author Khaled Hossain
 */
class ModalController
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
        Base::updateData(Base::filterData($_POST, [
            'public_profile_page',
            'backend_add_column',
            'backend_exclude_column'
        ]));
    }
}