<?php
namespace UserMeta\UserList;

/**
 * Controller for user listing
 *
 * @since 2.1
 * @author Sourov Amin
 */
class UserListController
{

    public function __construct()
    {
        /**
         * Add shortcode to display users list
         */
        add_shortcode('user-meta-user-list', [
            $this,
            'userListShortcode'
        ]);
        
    }

    /**
     * Include shortcode options
     * Initialize default values
     */
    public function userListShortcode($atts)
    {      
        $property = shortcode_atts( array(
        'caption' => '',
        'role' => 'all',
        'fields' => '',
        'link-field' => '',
        ),$atts);
        
        $caption = $property['caption'];
        $roles = $property['role'];
        $fieldsID = $property['fields'];
        $linkField = $property['link-field'];
        
        return (new DisplayList())->displayAllUser( $caption, $roles, $fieldsID, $linkField );   
    }

}