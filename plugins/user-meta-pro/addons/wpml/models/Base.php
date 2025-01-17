<?php
namespace UserMeta\Wpml2;

use UserMeta\AddonBase;

/**
 * Base for the addon
 *
 * @since 1.4
 * @author khaled Hossain
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