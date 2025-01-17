<?php
namespace UserMeta\UserList;

/**
 * Model for formatting UMP field to sync
 * 
 * @since 2.1
 * @author Sourov Amin
 */
class UMPFields
{
    /*
     * Fields to be excluded from the selection list
     */
    private $excludeFields = [
        'captcha',
        'page_heading',
        'section_heading'
    ];
    
    public $defaultColumns = [
        'Name',
        'Email',
        'Role',
        'Posts'
    ];
    
    /*
     * function to return available fields in formatted form
     */
    public function availableUMPFields(){
        global $userMeta;
        $fieldsAvailable = $userMeta->getData('fields');
        $fields = [];
        if(!empty($fieldsAvailable)){
            foreach ($fieldsAvailable as $key => $val) {
                
                $metaKey = !empty($val['meta_key']) ? $val['meta_key'] : $val['field_type'];
                $fieldTitle = ! empty($val['field_title']) ? $val['field_title'] : $metaKey;
                if( !empty($val['field_type']) &&  !in_array($val['field_type'], $this->excludeFields) )
                    $fields[$key] = $key.'. '.$fieldTitle.' ('.$metaKey.')';
            }
        }
        return $fields;
    }
    
    /*
     * Get selected fields data in usable format
     */
    public function getFormattedFields( $fieldsAvailable, $selectedFields )
    {
        $fields = [];  
        if( !empty( $selectedFields ) && !empty( $fieldsAvailable ) ){
            foreach($selectedFields as $key => $fieldNo){
                if( !empty($fieldsAvailable[ $fieldNo ]) ){
                    $val = $fieldsAvailable[ $fieldNo ];
                    $metaKey = !empty($val['meta_key']) ? $val['meta_key'] : $val['field_type'];
                    $fieldTitle = ! empty($val['field_title']) ? $val['field_title'] : $metaKey;
                    $fields[ $metaKey ] = $fieldTitle;
                }
            }
        }
        return $fields;
    }
    
}