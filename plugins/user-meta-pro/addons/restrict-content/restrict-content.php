<?php
/**
 * Hide/Display contents based on user status (restriction rules in page/post editor)
 * 
 * @since 2.2
 * @author Sourov Amin
 */
namespace UserMeta\RestrictContent;

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