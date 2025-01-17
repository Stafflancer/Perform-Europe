<?php

namespace UserMeta\WooCommerce;

use UserMeta\AddonBase;

/**
 * Base for the addon
 *
 * @since 2.1
 * @author Sourov Amin
 */
class Base extends AddonBase
{

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