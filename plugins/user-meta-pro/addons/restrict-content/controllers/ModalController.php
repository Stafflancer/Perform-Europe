<?php

namespace UserMeta\RestrictContent;

/**
 *
 * @since 2.2
 * @author Sourov Amin
 */
class ModalController
{

	public function __construct()
	{
		/**
		 * Build modal body
		 */
		add_action('user_meta_addon_modal_body_' . Base::name(), [
			$this,
			'modalBody'
		]);

		/**
		 * Store addon data
		 */
		add_action('user_meta_addon_save_data_' . Base::name(), [
			$this,
			'saveData'
		]);
	}

	/**
	 * Build modal body
	 */
	public function modalBody()
	{
		return Base::view('modalBody', [
			'data' => Base::getData()
		]);
	}

	/**
	 * Store addon data
	 */
	public function saveData()
	{
		Base::updateData(Base::filterData(\UserMeta\sanitizeDeep($_POST), [
			'show_login_form',
			'access_denied_text',
			'loggedin_must_text'
		]));
	}
}