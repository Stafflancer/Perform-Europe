<?php
namespace UserMeta\MailChimp;

/**
 * Initial controller for the addon
 *
 * @since 2.5
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
            'data' => Base::getData(),
            'mc' => new McFunctions(),
            'fields' => (new FieldOptions())->fieldsData(),
            'list' => [
                'field' => __('Form Field with List ID Values', 'user-meta'),
                'text' => __('List IDs', 'user-meta')
            ],
            'tag' => [
                'no' => __('No Tag Option', 'user-meta'),
                'field' => __('Form Field with List Tag Values', 'user-meta'),
                'text' => __('Tag Values', 'user-meta')
            ],
            'delete' => [
                'no' => __('No Action', 'user-meta'),
                'remove' => __('Remove User from Mailchimp Lists', 'user-meta'),
                'unsub' => __('Make User Unsubscribed', 'user-meta')
            ]
        ]);
    }

    /**
     * Store addon data
     */
    public function saveData()
    {
        Base::updateData(Base::filterData(\UserMeta\sanitizeDeep($_POST), [
            'api_key',
            'subscription_on_registration',
            'subscription_on_profile',
            'subscription_without_permission',
            'permission_field',
            'list_selection_method',
            'list_selection_field',
            'list_selection_text',
            'tag_selection_method',
            'tag_selection_field',
            'tag_selection_text',
            'merge_fields',
            'user_delete_action'
        ]));
    }
}