<?php

namespace UserMeta\RestrictContent;

use UserMeta\Html\Html;

/**
 * View for Meta Box in post/page editor
 *
 * @since 2.2
 * @author Sourov Amin
 */
class PostMetaBox
{

	/**
	 * Get list of available roles
	 */
	private function getRoles()
	{
		global $wp_roles;
		return $wp_roles->get_names();
	}

	/**
	 * To display options in metabox
	 */
	public function display()
	{
		global $userMeta;
		global $post;
		$valueDisplay = get_post_meta($post->ID, Base::maps('post_meta_display'), true);
		$valueRoles = get_post_meta($post->ID, Base::maps('post_meta_roles'), true);
		$html = null;
		$allRoles = $this->getRoles();
		$choice = array(
			'all' => __('All', 'user-meta'),
			'loggedin' => __('Logged In User Only', 'user-meta'),
			'loggedout' => __('Logged Out User Only', 'user-meta'),
		);

		$userMeta->enqueueScripts([
			'bootstrap',
			'bootstrap-multiselect',
		], [
			'bootstrap',
			'bootstrap-multiselect'
		]);
		Base::enqueScript('um-restrict-meta-box.js');

		echo Base::view('metaBox', [
			'valueDisplay' => $valueDisplay,
			'$valueRoles' => $valueRoles,
			'allRoles' => $allRoles,
			'choice' => $choice
		]);
	}

}
