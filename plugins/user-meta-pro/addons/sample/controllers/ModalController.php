<?php
namespace UserMeta\Sample;

/**
 * Initial controller for the addon
 *
 * @since 1.4
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
        Base::enqueScript('um-sample.js');
        return Base::view('modalBody', [
            'data' => Base::getData(),
            'someVariable' => 'Sample Addon'
        ]);
    }

    /**
     * Store addon data
     */
    public function saveData()
    {
        Base::updateData(Base::filterData(\UserMeta\sanitizeDeep($_POST), [
            'active_hooks'
        ]));
    }
}