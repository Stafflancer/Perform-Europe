<?php

namespace UserMeta\Field;

use UserMeta\Html\Html;

/**
 * Handle YouTube Consent field.
 *
 * @author Sourov Amin
 * @since 2.2
 */
class Consent extends Base
{

	protected $inputType = 'checkbox';

	/**
	 * Check if the field is qualified to be added.
	 *
	 * @return bool
	 */
	protected function isQualified()
	{
		parent::isQualified();
		if (! empty($this->field['registration_only']) && 'registration' != $this->actionType) {
			return $this->isQualified = false;
		}

		return $this->isQualified;
	}
	
	protected function configure_()
	{
		$labelContent = ! empty($this->field['default_value']) ? html_entity_decode($this->field['default_value']) : '';
		$this->options = [
			1 => $labelContent
		];
	}

	protected function renderInput()
	{
		return Html::checkbox($this->fieldValue, $this->inputAttr, $this->options);
	}

}