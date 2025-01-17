<?php
/*
 * Plugin Name: User Meta Sample External Addon
 * Plugin URI: https://user-meta.com
 * Description: External Sample Addon.
 * Version: 0.1
 * Requires at least: 4.7
 * Requires PHP: 7.0
 * Author: User Meta Pro
 * Author URI: https://user-meta.com
 * License: GPLv2
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

add_filter('user_meta_external_addons_list', function($addonsList) {
  $addonsList['ext-sample'] = [
      'title' => 'External: Title to show on addons panel',
      'brief' => 'Description to show on addons panel',
      'icon' => 'fa-plug',
      'has_option' => true,
      'init_script' => dirname(__FILE__) . '/sample.php'
  ];

  return $addonsList;
});
