<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/aurovrata/
 * @since      1.0.0
 *
 * @package    Cf7sg_Dynamic_Checkbox
 * @subpackage Cf7sg_Dynamic_Checkbox/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cf7sg_Dynamic_Checkbox
 * @subpackage Cf7sg_Dynamic_Checkbox/admin
 * @author     Aurovrata V. <vrata@syllogic.in>
 */
class Cf7sg_Dynamic_Checkbox_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

  /**
  * Deactivate this plugin if Smart Grid plugin is deactivated.
  * Hooks on action 'admin_init'
  * @since 1.0
  */
  public function check_plugin_dependency() {
    if( !is_plugin_active('cf7-grid-layout/cf7-grid-layout.php') ){
        deactivate_plugins( 'cf7sg-dynamic-checkbox/cf7sg-dynamic-checkbox.php' );

        $button = '<a href="'.network_admin_url('plugins.php').'">Return to Plugins</a></a>';
        wp_die( '<p><strong>Dynamic Checkbox Extension</strong> requires <strong>Smart Grid-layout extension for Contact Form 7</strong> plugin, and has therefore been deactivated!</p>'.$button );

        return false;
    }
    return true;
  }
  /**
  * enqueue css for tag manager.
  * Hooked on 'cf7sg_enqueue_admin_editor_styles', fired on form editor pages..
  */
  public function enqueue_style(){
    
    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __DIR__ ) . 'admin/css/cf7sg-dynamic-checkbox-admin.css', array(), $this->version, 'all' );

  }

}
