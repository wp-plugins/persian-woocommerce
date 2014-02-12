<?php
/*
Plugin Name: ووکامرس پارسی
Plugin URI: http://woocommerce.ir
Description: بسته فارسی ساز ووکامرس پارسی به راحتی سیستم فروشگاه ساز ووکامرس را فارسی می کند. با فعال سازی افزونه ، واحد پولی ریال و تومان ایران و همچنین لیست استان های ایران به افزونه افزوده می شوند. پشتیبانی در <a href="http://www.woocommerce.ir/" target="_blank">ووکامرس پارسی</a>.
Version: 1.2
Requires at least: 3.0
Author: Woocommerce.ir
Author URI: http://www.woocommerce.ir
*/
require_once ( dirname(__FILE__) .'/include/rial-function.php');
require_once ( dirname(__FILE__) .'/include/iran-states.php');
require_once ( dirname(__FILE__) .'/replacetext.php');
require_once ( dirname(__FILE__) .'/include/widget.php');
require_once ( dirname(__FILE__) .'/include/admin.php');


class PersianWooommercPlugin {
	/**
	 * The current langauge
	 *
	 * @var string
	 */
	private $language;
	private $is_persian;
	public function __construct( $file ) {
		$this->file = $file;

		// Filters and actions
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		add_filter( 'load_textdomain_mofile', array( $this, 'load_mo_file' ), 10, 2 );
		add_action( 'activated_plugin',       array( $this, 'activated_plugin' ) );
	}

	public function activated_plugin() {
		$path = str_replace( WP_PLUGIN_DIR . '/', '', $this->file );

		if ( $plugins = get_option( 'active_plugins' ) ) {
			if ( $key = array_search( $path, $plugins ) ) {
				array_splice( $plugins, $key, 1 );
				array_unshift( $plugins, $path );

				update_option( 'active_plugins', $plugins );
			}
		}
	}

	public function plugins_loaded() {
		$rel_path = dirname( plugin_basename( $this->file ) ) . '/languages/';

		load_plugin_textdomain( 'wc_gravityforms', false, $rel_path );
	}

	////////////////////////////////////////////////////////////

	public function load_mo_file( $mo_file, $domain ) {
		if ( $this->language == null ) {
			$this->language = get_option( 'WPLANG', WPLANG );
			$this->is_persian = ( $this->language == 'fa' || $this->language == 'fa_IR' );
		}

		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			$this->is_persian = ( ICL_LANGUAGE_CODE == 'fa' );
		}

		if ( $this->is_persian ) {
			$domains = array(

				'woocommerce'                => array(
					'i18n/languages/woocommerce-fa_IR.mo'       => 'woocommerce/fa_IR.mo',
					'i18n/languages/woocommerce-admin-fa_IR.mo' => 'woocommerce/admin-fa_IR.mo'
				)
			);

			if ( isset( $domains[$domain] ) ) {
				$paths = $domains[$domain];

				foreach ( $paths as $path => $file ) {
					if ( substr( $mo_file, -strlen( $path ) ) == $path ) {
						$new_file = dirname( $this->file ) . '/languages/' . $file;

						if ( is_readable( $new_file ) ) {
							$mo_file = $new_file;
						}
					}
				}
			}
		}

		return $mo_file;
	}
}

global $woocommerce_persian;

$woocommerce_persian = new PersianWooommercPlugin( __FILE__ );


function persian_woo_install() {
	global $wpdb;
	$persian_woocommerce_table = $wpdb -> prefix . "woocommerce_ir";
	$woocommerce_ir_sql = "CREATE TABLE IF NOT EXISTS $persian_woocommerce_table (
     `id` int(11) NOT NULL AUTO_INCREMENT,
     `text1` text CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL,
	 `text2` text CHARACTER SET utf8 COLLATE utf8_persian_ci,
      PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($woocommerce_ir_sql);
}

register_activation_hook(__FILE__, 'persian_woo_install');

