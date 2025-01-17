<?php
global $userMeta;

// var_dump($formBuilder);

// $fieldList = ! empty( $userMeta->form_editor->fieldsListforConditionalSelect ) ? $userMeta->form_editor->fieldsListforConditionalSelect : array();

extract($rule);
?>

<div class="form-group row">
	<div class="offset-sm-3 col-sm-9 d-inline-flex">
        
        <?php
        echo $userMeta->createInput('', 'select', array(
            'value' => isset($field_id) ? $field_id : null,
            'by_key' => true,
            'class' => 'um_conditional_field_id form-control',
            'style' => 'width:35%',
            'after' => '&nbsp;'
        ), $fieldList);
        
        echo $userMeta->createInput("", "select", array(
            'value' => isset($condition) ? $condition : null,
            'by_key' => true,
            'class' => 'um_conditional_condition form-control',
            'style' => 'width:20%',
            'after' => '&nbsp;'
        ), array(
            'is' => 'is',
            'is_not' => 'is not'
        ));
        
        echo $userMeta->createInput("", "text", array(
            'value' => isset($value) ? $value : null,
            'class' => 'um_conditional_value form-control',
            'style' => 'width:20%',
            'after' => '&nbsp;'
        ));
        
        ?>
        
        <button type="button"
			class="btn btn-secondary um_conditional_plus">
			<i class="fa fa-plus"></i>
		</button>
		<button type="button" class="btn btn-secondary um_conditional_minus">
			<i class="fa fa-minus"></i>
		</button>

	</div>
</div>