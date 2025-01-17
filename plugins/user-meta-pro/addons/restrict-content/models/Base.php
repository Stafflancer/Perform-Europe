<?php

namespace UserMeta\RestrictContent;

use UserMeta\AddonBase;

/**
 * Base for the addon
 *
 * @since 2.2
 * @author Sourov Amin
 */
class Base extends AddonBase
{

		/**
		 * Maps array to store key => value.
		 *
		 * @var array
		 */
		protected static $maps = [
				'post_meta_display' => 'user_meta_restrict_content_display',
				'post_meta_roles' => 'user_meta_restrict_content_roles',
		];

		/**
		 * We need to re initialize the property to store add-on's specific data
		 *
		 * @var array
		 */
		protected static $addonData = [];

		/**
		 * Plugin namespace
		 */
		protected static $namespace = __NAMESPACE__;
}
