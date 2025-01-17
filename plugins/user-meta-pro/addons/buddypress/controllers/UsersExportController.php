<?php
namespace UserMeta\BuddyPress;

/**
 * Controller for exporting BuddyPress xProfile fields
 *
 * @since 1.4
 * @author khaled Hossain
 */
class UsersExportController
{

    public function __construct()
    {
        /**
         * Include xProfile fields to user exportable fields list
         */
        add_filter('user_meta_user_exportable_fields', [
            $this,
            'includeXProfileFields'
        ]);
        
        /**
         * Populate xprofile data from field
         */
        add_filter('user_meta_user_export_pre_field_data', [
            $this,
            'populateXProfileData'
        ], 10, 3);
    }

    /**
     * Include xProfile fields to user exportable fields list
     * Use xprofile_[id] format as field key
     *
     * @param array $fields            
     * @return array
     */
    public function includeXProfileFields(array $fields)
    {
        foreach ((new XProfile())->getFields() as $id => $field) {
            $fields['xprofile_' . $id] = $field['name'];
        }
        
        return $fields;
    }

    /**
     * Populate xprofile data from field
     *
     * @param mixed $fieldValue            
     * @param string $key            
     * @param int $userID            
     * @return mixed
     */
    public function populateXProfileData($fieldValue, $key, $userID)
    {
        if (preg_match('/^xprofile_(\d+)$/', $key, $matches)) {
            $fieldValue = (new XProfile())->getFieldData($matches[1], $userID);
        }
        
        return $fieldValue;
    }
}