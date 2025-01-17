<?php
namespace UserMeta\BuddyPress;

/**
 * All xProfile related functions for BuddyPress
 *
 * @since 1.4
 * @author khaled Hossain
 */
class XProfile
{

    /**
     * Get all xProfile fields
     *
     * @return array [field_id: [name, group_name]]
     */
    public function getFields()
    {
        $args = [
            'hide_empty_groups' => true,
            'fetch_fields' => true
        ];
        
        $fields = [];
        foreach (bp_xprofile_get_groups($args) as $group) {
            foreach ($group->fields as $field) {
                $fields[$field->id] = [
                    'name' => $field->name,
                    'group_name' => $group->name
                ];
            }
        }
        
        return $fields;
    }

    /**
     * Get data for target field
     *
     * @param int $fieldID            
     * @param int $userID            
     * @return mixed
     */
    public function getFieldData($fieldID, $userID)
    {
        return xprofile_get_field_data($fieldID, $userID);
    }
}