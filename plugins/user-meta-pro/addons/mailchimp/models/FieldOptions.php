<?php

namespace UserMeta\MailChimp;

use UserMeta\OptionData;

/**
 * Process available field options
 *
 * @since 2.5
 * @author khaled Hossain
 */
class FieldOptions
{
    /**
     * Get the shared fields processed data
     * @return array
     */
    public function fieldsData()
    {
        $fieldsAvailable = OptionData::getFields();
        $fields = ['' => null];
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

    /**
     * Get merge values with user data
     * @return array
     */
    public function getMergeValues($mergeInput, $user)
    {
        $mergeOutput = [];
        $mergeArray = explode(',',$mergeInput);

        foreach($mergeArray as $element){
            $value= explode(':',$element);
            $tag = trim($value[0]);
            $key = trim($value[1]);
            $userData = $user->{$key};
            $mergeOutput[$tag] = $userData;
        }
        return $mergeOutput;
    }
}