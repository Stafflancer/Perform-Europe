<?php
/**
 *
 * Integrate UMP's shared fields with WooCommere and export/import WooCommerce fields data.
 * Import/export woocommerce fields with UMP export/import tools.
 * Add UMP fields to WooCommerce registration, profile, and checkout (with different positioning options) pages.
 * Display user inserted UMP fields data in “Order Main Page“ and “Order Preview Page“.
 *
 * @since 2.2
 * @author Sourov Amin
 */

namespace UserMeta\WooCommerce;

/**
 * Autoload models classes
 */
spl_autoload_register(function ($class) {
	$class = substr($class, strlen(__NAMESPACE__) + 1);
	$class = str_replace('\\', '/', $class);
	$path = dirname(__FILE__) . '/models/' . $class . '.php';
	if (is_readable($path)) {
		require_once $path;
	}
});

Base::init(__FILE__);
Base::loadControllers();
