<?php
/*
Contributors: Persianscript
Plugin Name: ووکامرس پارسی
Plugin URI: http://woocommerce.ir
Description: بسته فارسی ساز ووکامرس پارسی به راحتی سیستم فروشگاه ساز ووکامرس را فارسی می کند. با فعال سازی افزونه ، واحد پولی ریال و تومان ایران و همچنین لیست استان های ایران به افزونه افزوده می شوند. پشتیبانی در <a href="http://www.woocommerce.ir/" target="_blank">ووکامرس پارسی</a>.
Version: 2.3.9.2
Requires at least: 3.9
Author: ووکامرس فارسی
Author URI: http://www.woocommerce.ir
*/
require_once ( dirname(__FILE__) .'/include/rial-function.php');
require_once ( dirname(__FILE__) .'/include/iran-states.php');
require_once ( dirname(__FILE__) .'/replacetext.php');
require_once ( dirname(__FILE__) .'/include/widget.php');
require_once ( dirname(__FILE__) .'/include/admin.php');
require_once ( dirname(__FILE__) .'/include/rtl.php');
if ( get_option( 'woocommerce_iran_cities' ) == 'yes' )
	require_once ( dirname(__FILE__) .'/include/iran-cities/iran_cities.php');
class PersianWooommercePlugin {
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
		add_action( 'plugins_loaded', array( $this, 'load_mo_file' ) );
		add_action( 'activated_plugin',       array( $this, 'activated_plugin' ) );
		add_filter( 'woocommerce_general_settings', array( $this, 'add_iran_cities_enable_settings') );
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

	public function load_mo_file() {
		$rel_path = dirname( plugin_basename( $this->file ) ) . '/languages/';
		$dir    = plugin_dir_path( __FILE__ );
		
		if ( $this->language == null ) {
			$this->language = get_option( 'WPLANG', WPLANG );
			$this->is_persian = ( $this->language == 'fa' || $this->language == 'fa_IR' );
		}
		
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			$this->is_persian = ( ICL_LANGUAGE_CODE == 'fa' );
		}
		
		$curLang = substr(get_bloginfo( 'language' ), 0, 2);
	
		if ( $this->is_persian || strtolower($curLang) == 'fa' ) {
			
			if ( is_admin() )
				load_textdomain( 'woocommerce', $dir . 'languages/woocommerce/admin-fa_IR.mo' );
	
			load_textdomain( 'woocommerce', $dir . 'languages/woocommerce/fa_IR.mo' );
		}
	}
	
	public function add_iran_cities_enable_settings( $settings ) {
		$updated_settings = array();
		foreach ( $settings as $section ) {
			if ( isset( $section['id'] ) && 'general_options' == $section['id'] &&
			isset( $section['type'] ) && 'sectionend' == $section['type'] ) {
				$updated_settings[] = array(
					'name'     => __( 'فعالسازی شهرهای ایران' ),
					'id'       => 'woocommerce_iran_cities',
					'type'     => 'checkbox',
					'std'      => '1',  // WC < 2.0
					'default'  => '1',  // WC >= 2.0
					'desc'     => __( 'فعالسازی شهرهای ایران در صفحه تسویه حساب ( نسخه آزمایشی )' ),
				);						
			}
			$updated_settings[] = $section;
		}
		return $updated_settings;
	}

}
global $woocommerce_persian;
$woocommerce_persian = new PersianWooommercePlugin( __FILE__ );


add_action( 'plugins_loaded', 'persian_woo_plugin_loaded' );
function persian_woo_plugin_loaded() {
	if ( get_option( 'is_cities_installed') == 'yes' ) 
		return;
	
	global $wpdb;
	$Woo_Iran_Cities_By_HANNANStd = $wpdb->prefix . 'Woo_Iran_Cities_By_HANNANStd';
	if($wpdb->get_var("show tables like '$Woo_Iran_Cities_By_HANNANStd'") != $Woo_Iran_Cities_By_HANNANStd) {	
		$sql_cities = "CREATE TABLE IF NOT EXISTS " . $Woo_Iran_Cities_By_HANNANStd . " (
		`id` mediumint(9) NOT NULL AUTO_INCREMENT,
		`state` tinytext NOT NULL,
		`city` tinytext NOT NULL,
		UNIQUE KEY id (id)
		) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql_cities);
		$iran_city_file = plugin_dir_path( __FILE__ ). '/include/iran-cities/data/iran_cities.csv';
		$lines =  file($iran_city_file);
		foreach( (array) $lines as $line_num => $line) {
			$row = explode(",",$line);
			$len = sizeof($row);
			for($i=0;$i<$len;$i++){
				$row[$i] = sanitize_text_field($row[$i]);
			}
			$iran_city_fields = array (
				'state' => $row[0],
				'city' => $row[1]
			);
			$wpdb->insert( $Woo_Iran_Cities_By_HANNANStd ,$iran_city_fields);
		}
	}
	update_option( 'is_cities_installed', 'yes' );
}


function persian_woo_install() {
	update_option( 'redirect_to_woo_persian_about_page', 'no' );
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

function uninstall_woo_iran_cities() {
	update_option( 'is_cities_installed', 'no' );
	update_option( 'redirect_to_woo_persian_about_page', 'no' );
	global $wpdb;
	$table = $wpdb->prefix . 'Woo_Iran_Cities_By_HANNANStd';
	$wpdb->query("DROP TABLE IF EXISTS $table");
}
register_deactivation_hook( __FILE__, 'uninstall_woo_iran_cities' );

function redirect_to_woo_persian_about_page() {
	if ( get_option( 'redirect_to_woo_persian_about_page' ) != 'yes') {
		update_option( 'redirect_to_woo_persian_about_page', 'yes' );
		ob_start();
		ob_end_flush();
		ob_end_clean();
		if (!headers_sent()) {
			wp_redirect( admin_url( 'admin.php?page=persian-woocommerce' ) );
		}
		else {
			$redirect_page = admin_url( 'admin.php?page=persian-woocommerce' );
			echo "<script type='text/javascript'>window.onload = function () { top.location.href = '" . $redirect_page . "'; };</script>";
		}
    }
}
add_action('admin_init', 'redirect_to_woo_persian_about_page');