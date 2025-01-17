<?php
namespace UserMeta\WooCommerce;

use UserMeta\OptionData;

/**
 *
 * @since 2.1
 * @author Sourov Amin
 */
class UmpFields
{

    /*
     * Fields to be excluded from the selection list
     */
    private $excludeFields = [
        'captcha',
        'page_heading'
    ];

    /*
     * function to return available fields in formatted form
     */
    public function availableUmpFields()
    {
        $fieldsAvailable = OptionData::getFields();
        $fields = [];
        if (! empty($fieldsAvailable)) {
            foreach ($fieldsAvailable as $key => $val) {
                $metaKey = ! empty($val['meta_key']) ? $val['meta_key'] : $val['field_type'];
                $fieldTitle = ! empty($val['field_title']) ? $val['field_title'] : $metaKey;
                if (! empty($val['field_type']) && ! in_array($val['field_type'], $this->excludeFields)) {
                    $fields[$key] = $key . '. ' . $fieldTitle . ' (' . $metaKey . ')';
                }
            }
        }
        return $fields;
    }

    /*
     * function to return proccessed fields data to be used in WooCommerce format
     * @param array $data
     * return array $fields
     */
    public function proccessFieldsData($data)
    {
        $fields = [];

        foreach ($data as $key => $val) {
            $metaKey = ! empty($val['meta_key']) ? $val['meta_key'] : $val['field_type'];
            $fieldType = ! empty($val['field_type']) ? $val['field_type'] : 'text';
            $fieldTitle = ! empty($val['field_title']) ? $val['field_title'] : '';
            $description = ! empty($val['description']) ? $val['description'] : '';
            $placeholder = ! empty($val['placeholder']) ? $val['placeholder'] : '';
            $required = ! empty($val['required']) ? true : false;
            $class = ! empty($val['css_class']) ? [
                $val['css_class']
            ] : [];
            $inputClass = ! empty($val['field_class']) ? [
                $val['field_class']
            ] : [];
            $options = [];
            if (! empty($val['options'])) {
                foreach ($val['options'] as $opKey => $opVal) {
                    $options[$opVal['value']] = $opVal['label'];
                }
            }
            $default = ! empty($val['default_value']) ? $val['default_value'] : '';

            $fields[$metaKey] = [
                'type' => $fieldType,
                'label' => $fieldTitle,
                'description' => $description,
                'placeholder' => $placeholder,
                // 'maxlength' => false,
                'required' => $required,
                // 'autocomplete'=> false,
                'id' => $metaKey,
                'class' => $class,
                // 'label_class' => [],
                'input_class' => $inputClass,
                // 'return' => false,
                'options' => $options,
                'validate' => array(),
                'default' => $default
                // 'autofocus' => '',
                // 'priority' => '',
            ];
        }
        return $fields;
    }

    /*
     * Get selected fields data in usable format
     */
    public function getFormattedFields($fieldsAvailable, $selectedFields)
    {
        $fields = [];
        if (! empty($selectedFields)) {
            foreach ($selectedFields as $key => $val) {
                if (! empty($fieldsAvailable[$val])) {
                    $fields[$val] = $fieldsAvailable[$val];
                }
            }
        }
        return $fields;
    }
}