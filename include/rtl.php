<?php
// این قسمت از پلاگین زیر اقتباس شده است :
// https://wordpress.org/plugins/woocommerce-rtl/
  /**
   * Admin styles
   */
  add_action( 'admin_enqueue_scripts', 'persian_woo_rtl_admin_styles', 11 );
  function persian_woo_rtl_admin_styles() {
    if ( is_rtl() ) {
      // menu.css
      wp_dequeue_style( 'woocommerce_admin_menu_styles' );
      wp_dequeue_style( 'woocommerce_admin_menu_styles_rtl' );
	  wp_enqueue_style( 'woocommerce_admin_menu_styles_rtl', plugins_url('/rtl/assets/css/menu.css',__FILE__), array(), WC_VERSION );

      $screen = get_current_screen();

      // admin.css
      if ( in_array( $screen->id, wc_get_screen_ids() ) ) {
        wp_dequeue_style( 'woocommerce_admin_styles' );
        wp_dequeue_style( 'woocommerce_admin_styles_rtl' );
        wp_enqueue_style( 'woocommerce_admin_styles_rtl', plugins_url('/rtl/assets/css/admin.css',__FILE__), array(), WC_VERSION );
        wp_enqueue_style( 'persian_woo_rtl_admin_styles', plugins_url('/rtl/assets/css/persian_woo_rtl-admin.css',__FILE__), array(), WC_VERSION );
      }

      // dashboard.css
      if ( in_array( $screen->id, array( 'dashboard' ) ) ) {
        wp_dequeue_style( 'woocommerce_admin_dashboard_styles' );
        wp_dequeue_style( 'woocommerce_admin_dashboard_styles_rtl' );
        wp_enqueue_style( 'woocommerce_admin_dashboard_styles_rtl', plugins_url('/rtl/assets/css/dashboard.css',__FILE__), array(), WC_VERSION );
      }

      // reports-print.css
      if ( in_array( $screen->id, array( 'woocommerce_page_wc-reports' ) ) ) {
        wp_dequeue_style( 'woocommerce_admin_dashboard_styles' );
        wp_dequeue_style( 'woocommerce_admin_print_reports_styles_rtl' );
        wp_enqueue_style( 'woocommerce_admin_print_reports_styles_rtl', plugins_url('/rtl/assets/css/reports-print.css',__FILE__), array(), WC_VERSION, 'print' );
      }

    }

  }