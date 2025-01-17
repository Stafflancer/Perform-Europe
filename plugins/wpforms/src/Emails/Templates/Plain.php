<?php

namespace WPForms\Emails\Templates;

/**
 * Class Plain.
 * This template is used for the plain text email notifications.
 *
 * @since 1.8.5
 */
class Plain extends Notifications {

	/**
	 * Template slug.
	 *
	 * @since 1.8.5
	 *
	 * @var string
	 */
	const TEMPLATE_SLUG = 'plain';

	/**
	 * Initialize class.
	 *
	 * @since 1.8.5
	 *
	 * @param string $message    Message.
	 * @param bool   $is_preview Whether is preview or not. Default false.
	 *                           This variable has been left here to keep the same number of constructor arguments as the parent class.
	 */
	public function __construct( $message = '', $is_preview = false ) {

		// Call the parent class contractor to ensure we are all prepared for the initialization.
		parent::__construct( $message, $is_preview );

		// We already know that this is a plain text template. No need for further evaluation.
		$this->plain_text = true;

		// Call the parent method after to set the correct header properties.
		$this->set_initial_args();
	}

	/**
	 * Maybe prepare the content for the preview.
	 *
	 * @since 1.8.5
	 *
	 * @param string $content Content with no styling applied.
	 */
	protected function save_styled( $content ) {

		// Leave early if we are not in preview mode.
		if ( ! $this->is_preview ) {
			// Call the parent method to handle the proper styling.
			parent::save_styled( $content );

			return;
		}

		// Leave if content is empty.
		if ( empty( $content ) ) {
			$this->content = '';

			return;
		}

		// Stop here as we don't need to apply any styling for the preview.
		// The only exception here is to keep the break tags to maintain the readability.
		$this->content = wp_kses( $content, [ 'br' => [] ] );
	}
}
