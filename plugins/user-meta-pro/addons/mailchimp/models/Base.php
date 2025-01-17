<?php
namespace UserMeta\MailChimp;

use UserMeta\AddonBase;

/**
 * Base for the addon
 *
 * @since 2.5
 * @author khaled Hossain
 */
class Base extends AddonBase
{

    /**
     * Maps array to store key => value.
     *
     * @var array
     */
    protected static $maps = [];

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
