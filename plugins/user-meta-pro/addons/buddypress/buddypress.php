<?php
/**
 * BuddyPress addon for UserMeta
 *
 * @since 1.4
 * @author khaled Hossain
 */
namespace UserMeta\BuddyPress;

/**
 * Autoload models classes
 */
spl_autoload_register(function ($class) {
    $class = substr($class, strlen(__NAMESPACE__) + 1);
    $class = str_replace('\\', '/', $class);
    $path = dirname(__FILE__) . '/models/' . $class . '.php';
    if (is_readable($path))
        require_once $path;
});

/**
 * Load the addon in bp_include action to make sure BuddyPress is loadeding and initialized
 */
add_action('bp_include', function () {
    Base::init(__FILE__);
    Base::loadControllers();
});