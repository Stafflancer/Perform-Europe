<?php
/**
 * An example addon as reference.
 * 
 * @since 1.4
 * @author khaled Hossain
 */
namespace UserMeta\Sample;

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