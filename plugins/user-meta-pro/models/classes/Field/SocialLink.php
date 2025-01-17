<?php

namespace UserMeta\Field;

/**
 * Handle social link field.
 *
 * @author Sourov Amin
 * @since 2.2
 */
class SocialLink extends Base
{
	protected $inputType = 'url';

	private $regex = [
		'facebook' => '(?:http[s]?:\/\/)?(?:www\.)?(mbasic.facebook|m\.facebook|facebook|fb)\.(com|me)\/(?:(?:\w\.)*#!\/)?(?:pages\/)?(?:[\w\-\.]*\/)*([\w\-\.]*)',
		'twitter' => '(?:http[s]?:\/\/)?(?:www\.)?twitter\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-]*)',
		'linkedin' => '(?:http[s]?:\/\/)?(?:www\.)?(?:[a-z|.]{0,3})linkedin\.com\/.*$',
		'google_plus' => '(?:http[s]?:\/\/)?(?:www\.)?plus\.google\.com\/.*$',
		'instagram' => '(?:http[s]?:\/\/)?(?:www\.)?instagram\.com\/.*$',
		'skype' => '[a-zA-Z][a-zA-Z0-9\.,\-_]{5,31}',
		'youtube' => '^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$',
		'soundcloud' => '(?:http[s]?:\/\/)?(?:www\.)?(?:m\.)?(soundcloud\.com|snd\.sc)\/.*$'
	];

	/**
	 * Error text if the input is invalid
	 */
	private function errorText()
	{
		if (!empty($this->field['error_text'])) {
			return $this->field['error_text'];
		}

		global $userMeta;
		$linkText = strtoupper(str_replace('_', ' ', $this->field['link_type']));
		return sprintf(__('Invalid %s URL', $userMeta->name), $linkText);
	}

	protected function _configure()
	{
		if ($this->field['link_type'] == 'skype') {
			$this->inputType = 'text';
		} else {
			$this->addValidation('custom[url]');
		}
	}

	protected function configure_()
	{
		if (!empty($this->regex[$this->field['link_type']])) {
			$this->inputAttr['pattern'] = $this->regex[$this->field['link_type']];
			$this->inputAttr['oninput'] = "setCustomValidity('')";
			$this->inputAttr['oninvalid'] = "setCustomValidity('{$this->errorText()}')";
		}
	}
}