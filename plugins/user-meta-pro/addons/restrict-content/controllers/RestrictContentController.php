<?php

namespace UserMeta\RestrictContent;

/**
 * Controller for Meta Box in post/page editor and restrict content
 *
 * @since 2.2
 * @author Sourov Amin
 */
class RestrictContentController
{

	public function __construct()
	{
		add_action('add_meta_boxes', [
			$this,
			'metaBoxDisplay'
		]);

		add_action('save_post', [
			$this,
			'metaBoxSave'
		], 10, 2);

		add_filter('the_content', [
			$this,
			'contentRestriction'
		], 10, 1);
	}

	/**
	 * Adding meta box to page/post editor
	 */
	public function metaBoxDisplay()
	{
		add_meta_box(
			'um_restrict_content_display',
			__('UMP Restrict Content', 'user-meta'),
			[$this, 'metaBoxContent'],
			['post', 'page'],
			'side',
			'default'
		);
	}

	/**
	 * Display Meta Box
	 */
	public function metaBoxContent()
	{
		$view = new PostMetaBox();
		$view->display();
		wp_nonce_field('um_restrict_content_nonce', 'um_restrict_content_process');
	}

	/**
	 * Save meta box data
	 */
	public function metaBoxSave($post_id, $post)
	{
		// Security, permission and submission verification
		if (!isset($_POST['um_restrict_content_process']) || !isset($_POST['um_restrict_content_display']) || !wp_verify_nonce($_POST['um_restrict_content_process'],
				'um_restrict_content_nonce') || !current_user_can('edit_post', $post->ID)) {
			return;
		}

		// Save our submissions to the database
		update_post_meta($post->ID, Base::maps('post_meta_display'), sanitize_key($_POST['um_restrict_content_display']));
		if (!empty($_POST['um_restrict_content_roles'])) {
			$displayRole = array_map('sanitize_key', $_POST['um_restrict_content_roles']);
			update_post_meta($post->ID, Base::maps('post_meta_roles'), $displayRole);
		}
	}

	/**
	 * Restrict content by modifying the content
	 */
	public function contentRestriction($content)
	{
		global $post;
		global $userMeta;
		$data = Base::getData();
		$valueDisplay = get_post_meta($post->ID, Base::maps('post_meta_display'), true);
		$valueRoles = get_post_meta($post->ID, Base::maps('post_meta_roles'), true);
		$loginForm = !empty($data['show_login_form']) ? true : false;
		$accessDenied = !empty($data['access_denied_text']) ? $data['access_denied_text'] : __('You don\'t have permission to access this content!',
			'user-meta');
		$loggedinOnly = !empty($data['loggedin_must_text']) ? $data['loggedin_must_text'] : __('You must be logged in to view this content!',
			'user-meta');

		// If display content not set or set to all
		if (empty($valueDisplay) || $valueDisplay == 'all') {
			return $content;
		}

		// If user is logged in
		if (is_user_logged_in()) {
			// If content is displayed only to logged out user
			if ($valueDisplay == 'loggedout') {
				$userMeta->enqueueScripts(['user-meta']);
				$content = '<div class="pf_warning">' . $accessDenied . '</div>';
			} // Content displayed to logged in user but hide from some role
			else {
				if (!empty($valueRoles)) {
					$user = wp_get_current_user();
					$userRoles = ( array )$user->roles;
					foreach ($valueRoles as $key => $role) {
						if (in_array($role, $userRoles)) {
							$userMeta->enqueueScripts(['user-meta']);
							$content = '<div class="pf_warning">' . $accessDenied . '</div>';
							break;
						}
					}
				}
			}
		} // If user is not logged in
		else {
			if ($valueDisplay == 'loggedin') {
				$userMeta->enqueueScripts(['user-meta']);
				$content = '<div class="pf_warning">' . $loggedinOnly . '</div>';
				if ($loginForm) {
					if (is_singular()) {
						$content .= '[user-meta-login]';
					}
				}
			}
		}

		return $content;
	}

}
