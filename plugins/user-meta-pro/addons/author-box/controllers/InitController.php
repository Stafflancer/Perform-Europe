<?php
namespace UserMeta\AuthorBox;

/**
 * Initial controller for the addon
 *
 * @since 1.4
 * @author Sourov Amin
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
            'data' => Base::getData(),
            'fields' => (new FieldOptions())->availableFields(),
            'choice' => [
                'yes' => __('Yes', 'user-meta'),
                'no' => __('No', 'user-meta'),
            ],
            'theme' => [
                'plain' => __('Plain', 'user-meta'),
            ],
            'name_type' => [
                'display_name' => __('Display Name', 'user-meta'),
                'first_last' => __('First+Last Name', 'user-meta'),
            ],
            'position' => [
                'after' => __('After Post', 'user-meta'),
                'before' => __('Before Post', 'user-meta'),
            ]
        ]);
    }

    /**
     * Store addon data
     */
    public function saveData()
    {
        Base::updateData(Base::filterData($_POST, [
            'description',
            'designation',
            'contact_no',
            'portfolio',
            'facebook',
            'linkedin',
            'twitter',
            'theme',
            'position',
            'name_type',
            'set_posts',
            'set_pages',
            'show_recent_post',
            'show_email',
            'show_contact_no',
            'show_portfolio',
            'show_facebook',
            'show_linkedin',
            'show_twitter',
        ]));
    }
}