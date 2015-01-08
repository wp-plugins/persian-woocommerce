<?php

// plugin folder url
if(!defined('RC_SCD_PLUGIN_URL')) {
	define('RC_SCD_PLUGIN_URL', plugin_dir_url( __FILE__ ));
}


class woocommerce_persian_dashboard {
 
	function __construct() {
	
		add_action('admin_menu', array( $this,'woo_persian_create_menu') ); 
	} 
 
	
	
	
	function woo_persian_create_menu() {
		add_menu_page( 'ووکامرس فارسی', 'ووکامرس فارسی', 8,'persian-woocommerce', array($this,'persian_woo_dash') ,  plugins_url( 'images/logo.png' , __FILE__ ) );
		add_submenu_page('persian-woocommerce', 'افزودن حلقه‌ ترجمه', 'افزودن حلقه‌ ترجمه', 8, 'persian-woocommerce-add', array($this,'persian_woo_add_text'));
		add_submenu_page('persian-woocommerce', 'ویرایش حلقه', 'ویرایش حلقه', 8, 'persian-woocommerce-edit', array($this,'persian_woo_edit_text'));

	}
	
	function persian_woo_dash() {
		include_once( 'woocommerce-persian-about.php'  );
	}
	function persian_woo_edit_text() {
		include_once( 'admin/woocommerce-text.php'  );
		woo_persian_list_text();
	}
	function persian_woo_add_text() {
		include_once( 'admin/woocommerce-replace-text.php'  );
		woo_persian_add_list_text();
	}

 
}

$GLOBALS['sweet_custom_dashboard'] = new woocommerce_persian_dashboard();

?>