<?php
/**
 * Uninstall
 */
 if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}
$path=plugin_dir_path(__FILE__);
include_once($path . "cf7-pipedrive-pro.php");
 include_once($path . "includes/install.php");
   $install=new vxcf_pipedrive_install();
   $settings=get_option($install->id.'_settings',array());
if(!empty($settings['plugin_data'])){
  $install->remove_data();
}

