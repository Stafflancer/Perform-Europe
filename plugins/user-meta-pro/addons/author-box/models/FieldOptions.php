<?php
namespace UserMeta\AuthorBox;

/**
 *
 * @since 2.4
 * @author Sourov Amin
 */
class FieldOptions
{
    /*
     * function to return available fields
     */
    public function availableFields()
    {
        global $userMeta;
        $fieldsAvailable = $userMeta->getData('fields');
        $fields = [
            '' => null,
            'user_description' => __('Biographical Info', 'user-meta'),
        ];
        if(!empty( $fieldsAvailable )){
            foreach ( $fieldsAvailable as $key => $val ) {
                if( isset($val['meta_key']) ){
                    $fields[$val['meta_key']] = !empty( $val['field_title'] ) ? $val['field_title'] : 'Field: '.$key;
                }
                else{
                    $fields[$val['field_type']] = !empty( $val['field_title'] ) ? $val['field_title'] : 'Field: '.$key;
                }
            }
        }
        return $fields;
    }
}