<?php
/**
 * Switch filter or action hooks.
 * Deactivate hooks to avoid plugin conflict, activate hooks to integrate with other plugins.
 *
 * @since 1.4
 * @author khaled Hossain
 */
namespace UserMeta\HookSwitch;

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

Base::init(__FILE__);
Base::loadControllers();