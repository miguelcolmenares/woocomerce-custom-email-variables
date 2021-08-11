<?php
/**
 * Plugin Name:       Custom Variables Woocommerce Email
 * Description:       Este plugin agrega la variable de ciudad para los correos de woocomerce
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Author:            Miguel Colmenares
 * Author URI:        https://miguelcolmenares.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       woocomerce-custom-email-variables
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CustomWoocommerceVariables {
	static $instance = false;

	public $plugin_version = '1.0';

	private function __construct() {
		// Text domain.
		add_action( 'init', array( $this, 'woocomerce_custom_email_variables_load_textdomain' ) );

		add_filter('woocommerce_email_subject_new_order', array( $this, 'change_admin_email_subject' ), 1, 2);
	}

	public static function getInstance() {
		if ( !self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

    public function woocomerce_custom_email_variables_load_textdomain() {
		load_plugin_textdomain( 'woocomerce-custom-email-variables', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}

    function change_admin_email_subject( $subject, $order ) {
        global $woocommerce;

        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $subject = sprintf( '[%s] Nuevo pedido #(%s) para %s', $blogname, $order->id, $order->shipping_city );

        return $subject;
    }
}

// Plugin init.
$CustomWoocommerceVariablesPlugin = CustomWoocommerceVariables::getInstance();