<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/aurovrata/
 * @since      1.0.0
 *
 * @package    Cf7sg_Dynamic_Checkbox
 * @subpackage Cf7sg_Dynamic_Checkbox/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cf7sg_Dynamic_Checkbox
 * @subpackage Cf7sg_Dynamic_Checkbox/includes
 * @author     Aurovrata V. <vrata@syllogic.in>
 */
class Cf7sg_Dynamic_Checkbox_Activator {

  /**
  * Short Description. (use period)
  *
  * Long Description.
  *
  * @since    1.0.0
  */
  public static function activate() {
    if(!is_plugin_active( 'cf7-grid-layout/cf7-grid-layout.php' )){
      if(is_multisite()){
        exit(__('The Smart Grid-layout extension for Contact Form 7 plugin needs to be activated first. If you have activated it on select sites,
        you will need to activate the Dynamic Checkbox plugin on those sites only','cf7sg-dynamic-checkbox'));
      }
      exit(__('This plugin requires the Smart Grid-layout extension for Contact Form 7 plugin to be activated first', 'cf7sg-dynamic-checkbox') );
    }
  }
}
