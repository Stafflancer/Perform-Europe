<?php
/**
 * Wpml addon for UserMeta
 * 
 * Using UserMeta\Wpml2 namespace to avoid conflict with stale user-meta-wpml plugin
 *
 * @since 1.4
 * @author khaled Hossain
 */
namespace UserMeta\Wpml2;

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
 * We need to load in init action for translate to work
 */
add_action('init', function () {
    Base::init(__FILE__);
    Base::loadControllers();
});