<?php
if ( ! defined( 'ABSPATH' ) ) exit; 

add_filter( 'woocommerce_get_country_locale' ,  'iran_locale_By_HANNANStd' );
function iran_locale_By_HANNANStd($locales){
	$locales['IR']['state']['label'] = 'استان';
	return $locales;
}

add_filter( 'woocommerce_checkout_fields' ,  'add_iran_cities_to_checkout_By_HANNANStd', 0 );
function add_iran_cities_to_checkout_By_HANNANStd( $fields ) {		
	wp_deregister_script( 'wc-address-i18n' );
	wp_register_script( 'wc-address-i18n', plugins_url('/js/wc-address-i18n.js',__FILE__), array( 'jquery' ), WC_VERSION, true );	
	wp_enqueue_script( 'wc-address-i18n');
	
	$billing_fields = array(
		"billing_first_name", 
		"billing_last_name", 
		"billing_company",
		"billing_country", 
		"billing_state",
		"billing_city",
		"billing_address_1", 
		"billing_address_2", 
		"billing_postcode",
		"billing_email", 
		"billing_phone"
	);
	foreach( (array) $billing_fields as $field){
		$ordered_billing_fields[$field] = $fields["billing"][$field];
	}
	$fields["billing"] = $ordered_billing_fields;
	
	$shipping_fields = array(
		"shipping_first_name", 
		"shipping_last_name", 
		"shipping_company",
		"shipping_country", 
		"shipping_state",
		"shipping_city",
		"shipping_address_1", 
		"shipping_address_2", 
		"shipping_postcode"
	);
	foreach( (array) $shipping_fields as $field){
		$ordered_shipping_fields[$field] = $fields["shipping"][$field];
	}
	$fields["shipping"] = $ordered_shipping_fields;

	global $current_user;
	$user_id = $current_user ? $current_user->ID : 0;
	if ( $user_id and is_numeric($user_id) and $user_id > 0 ) {
		$billing_city = get_user_meta( $user_id, 'billing_city', true ) ? get_user_meta( $user_id, 'billing_city', true ) : 'شهر';	
		$shipping_city = get_user_meta( $user_id, 'shipping_city', true ) ? get_user_meta( $user_id, 'shipping_city', true ) : 'شهر';	
	}
	else {
		$billing_city = 'شهر';	
		$shipping_city = 'شهر';	
	}
	
	$fields['billing']['billing_state']['class'] = $fields['shipping']['shipping_state']['class'] = array( 'state_select', 'form-row', 'form-row-first','address-field','validate-required','update_totals_on_change');
	$fields['billing']['billing_city']['type'] = $fields['shipping']['shipping_city']['type'] = 'select';
	$fields['billing']['billing_city']['placeholder'] = $billing_city;
	$fields['shipping']['shipping_city']['placeholder'] = $shipping_city;
	
	$fields['billing']['billing_city']['class'] = $fields['shipping']['shipping_city']['class'] = array( 'state_select', 'form-row','form-row-last','address-field','validate-required','update_totals_on_change');
	$fields['billing']['billing_city']['options'] = $fields['shipping']['shipping_city']['options'] = get_cities_by_hannanstd('init');
	
	global $HANNANStd_City;
	$HANNANStd_City = array();
	$GLOBALS['HANNANStd_City_Billing_label'] = $HANNANStd_City['HANNANStd_City_Billing_label'] = isset($fields['billing']['billing_city']['label']) ? $fields['billing']['billing_city']['label'] : '';
	$GLOBALS['HANNANStd_City_Billing_class'] = $HANNANStd_City['HANNANStd_City_Billing_class'] = isset($fields['billing']['billing_city']['class']) ? implode(' ',$fields['billing']['billing_city']['class']) : '';
	$GLOBALS['HANNANStd_City_Billing_label_class'] = $HANNANStd_City['HANNANStd_City_Billing_label_class'] = isset($fields['billing']['billing_city']['label_class']) ? implode(' ',$fields['billing']['billing_city']['label_class']) : '';
	$GLOBALS['HANNANStd_City_Billing_required'] = $HANNANStd_City['HANNANStd_City_Billing_required'] = isset($fields['billing']['billing_city']['required']) ? $fields['billing']['billing_city']['required'] : '';
	$GLOBALS['HANNANStd_City_Billing_clear'] = $HANNANStd_City['HANNANStd_City_Billing_clear'] = isset($fields['billing']['billing_city']['clear']) ? $fields['billing']['billing_city']['clear'] : '';
	$GLOBALS['HANNANStd_City_Billing_placeholder'] = $HANNANStd_City['HANNANStd_City_Billing_placeholder'] = isset($fields['billing']['billing_city']['placeholder']) ? $fields['billing']['billing_city']['placeholder'] : '';
	$GLOBALS['HANNANStd_City_Shipping_label'] = $HANNANStd_City['HANNANStd_City_Shipping_label'] = isset($fields['shipping']['shipping_city']['label']) ? $fields['shipping']['shipping_city']['label'] : '';
	$GLOBALS['HANNANStd_City_Shipping_class'] = $HANNANStd_City['HANNANStd_City_Shipping_class'] = isset($fields['shipping']['shipping_city']['class']) ? implode(' ',$fields['shipping']['shipping_city']['class']) : '';
	$GLOBALS['HANNANStd_City_Shipping_label_class'] = $HANNANStd_City['HANNANStd_City_Shipping_label_class'] = isset($fields['shipping']['shipping_city']['label_class']) ? implode(' ',$fields['shipping']['shipping_city']['label_class']) : '';
	$GLOBALS['HANNANStd_City_Shipping_required'] = $HANNANStd_City['HANNANStd_City_Shipping_required'] = isset($fields['shipping']['shipping_city']['required']) ? $fields['shipping']['shipping_city']['required'] : '';
	$GLOBALS['HANNANStd_City_Shipping_clear'] = $HANNANStd_City['HANNANStd_City_Shipping_clear'] = isset($fields['shipping']['shipping_city']['clear']) ? $fields['shipping']['shipping_city']['clear'] : '';
	$GLOBALS['HANNANStd_City_Shipping_placeholder'] = $HANNANStd_City['HANNANStd_City_Shipping_placeholder'] = isset($fields['shipping']['shipping_city']['placeholder']) ? $fields['shipping']['shipping_city']['placeholder'] : '';
	return $fields;
}

add_action ('woocommerce_after_order_notes', 'change_select_class_By_HANNANStd',10);
function change_select_class_By_HANNANStd() {
	
	global $HANNANStd_City;
	$HANNANStd_City = array();
	
	$label_billing = isset($GLOBALS['HANNANStd_City_Billing_label']) ? $GLOBALS['HANNANStd_City_Billing_label'] : ( isset($HANNANStd_City['HANNANStd_City_Billing_label']) ? $HANNANStd_City['HANNANStd_City_Billing_label'] : '' );
	$label_class_billing = isset($GLOBALS['HANNANStd_City_Billing_label_class']) ? $GLOBALS['HANNANStd_City_Billing_label_class'] : ( isset($HANNANStd_City['HANNANStd_City_Billing_label_class']) ? $HANNANStd_City['HANNANStd_City_Billing_label_class'] : '' );
	$class_billing = isset($GLOBALS['HANNANStd_City_Billing_class']) ? $GLOBALS['HANNANStd_City_Billing_class'] : ( isset($HANNANStd_City['HANNANStd_City_Billing_class']) ? $HANNANStd_City['HANNANStd_City_Billing_class'] : '' );
	$required_billing = isset($GLOBALS['HANNANStd_City_Billing_required']) ? $GLOBALS['HANNANStd_City_Billing_required'] : ( isset($HANNANStd_City['HANNANStd_City_Billing_required']) ? $HANNANStd_City['HANNANStd_City_Billing_required'] : '' );
	$clear_billing = isset($GLOBALS['HANNANStd_City_Billing_clear']) ? $GLOBALS['HANNANStd_City_Billing_clear'] : ( isset($HANNANStd_City['HANNANStd_City_Billing_clear']) ? $HANNANStd_City['HANNANStd_City_Billing_clear'] : '' );
	$placeholder_billing = isset($GLOBALS['HANNANStd_City_Billing_placeholder']) ? $GLOBALS['HANNANStd_City_Billing_placeholder'] : ( isset($HANNANStd_City['HANNANStd_City_Billing_placeholder']) ? $HANNANStd_City['HANNANStd_City_Billing_placeholder'] : '' );

	$label_shipping = isset($GLOBALS['HANNANStd_City_Shipping_label']) ? $GLOBALS['HANNANStd_City_Shipping_label'] : ( isset($HANNANStd_City['HANNANStd_City_Shipping_label']) ? $HANNANStd_City['HANNANStd_City_Shipping_label'] : '' );
	$label_class_shipping = isset($GLOBALS['HANNANStd_City_Shipping_label_class']) ? $GLOBALS['HANNANStd_City_Shipping_label_class'] : ( isset($HANNANStd_City['HANNANStd_City_Shipping_label_class']) ? $HANNANStd_City['HANNANStd_City_Shipping_label_class'] : '' );
	$class_shipping = isset($GLOBALS['HANNANStd_City_Shipping_class']) ? $GLOBALS['HANNANStd_City_Shipping_class'] : ( isset($HANNANStd_City['HANNANStd_City_Shipping_class']) ? $HANNANStd_City['HANNANStd_City_Shipping_class'] : '' );
	$required_shipping = isset($GLOBALS['HANNANStd_City_Shipping_required']) ? $GLOBALS['HANNANStd_City_Shipping_required'] : ( isset($HANNANStd_City['HANNANStd_City_Shipping_required']) ? $HANNANStd_City['HANNANStd_City_Shipping_required'] : '' );
	$clear_shipping = isset($GLOBALS['HANNANStd_City_Shipping_clear']) ? $GLOBALS['HANNANStd_City_Shipping_clear'] : ( isset($HANNANStd_City['HANNANStd_City_Shipping_clear']) ? $HANNANStd_City['HANNANStd_City_Shipping_clear'] : '' );
	$placeholder_shipping = isset($GLOBALS['HANNANStd_City_Shipping_placeholder']) ? $GLOBALS['HANNANStd_City_Shipping_placeholder'] : ( isset($HANNANStd_City['HANNANStd_City_Shipping_placeholder']) ? $HANNANStd_City['HANNANStd_City_Shipping_placeholder'] : '' );
	?>
	<script type="text/javascript">	
		jQuery( '#billing_country' ).change(function(){
			if ( jQuery( this ).val() == 'IR' )
				jQuery('p#billing_city_field').replaceWith('<p id="billing_city_field" class="form-row state_select<?php echo $class_billing; ?>"><label class="<?php echo $label_class_billing; ?>" for="billing_city"><?php echo $label_billing; ?><?php echo $required_billing ? '<abbr class="required" title="'.esc_attr__( 'required', 'woocommerce'  ).'">*</abbr>' : ''; ?></label><select name="billing_city" id="billing_city" class="select state_select"  placeholder="<?php echo $placeholder_billing; ?>"><option value="">ابتدا استان را انتخاب نمایید</option></select></p><?php echo $clear_billing ? '<div class="clear"></div>' : '' ?>');
			else 
				jQuery('p#billing_city_field').replaceWith('<p id="billing_city_field" class="form-row <?php echo $class_billing; ?>"><label class="<?php echo $label_class_billing; ?>" for="billing_city"><?php echo $label_billing; ?><?php echo $required_billing ? '<abbr class="required" title="'.esc_attr__( 'required', 'woocommerce'  ).'">*</abbr>' : ''; ?></label><input id="billing_city" class="input-text " type="text" value="" placeholder="<?php echo $placeholder_billing; ?>" name="billing_city"></p><?php echo $clear_billing ? '<div class="clear"></div>' : '' ?>');
		}).change();
		jQuery( '#shipping_country' ).change(function(){
			if ( jQuery( this ).val() == 'IR' )
				jQuery('p#shipping_city_field').replaceWith('<p id="shipping_city_field" class="form-row state_select<?php echo $class_shipping; ?>"><label class="<?php echo $label_class_shipping; ?>" for="shipping_city"><?php echo $label_shipping; ?><?php echo $required_shipping ? '<abbr class="required" title="'.esc_attr__( 'required', 'woocommerce'  ).'">*</abbr>' : ''; ?></label><select name="shipping_city" id="shipping_city" class="select state_select"  placeholder="<?php echo $placeholder_shipping; ?>"><option value="">ابتدا استان را انتخاب نمایید</option></select></p><?php echo $clear_shipping ? '<div class="clear"></div>' : '' ?>');
			else 
				jQuery('p#shipping_city_field').replaceWith('<p id="shipping_city_field" class="form-row <?php echo $class_shipping; ?>"><label class="<?php echo $label_class_shipping; ?>" for="shipping_city"><?php echo $label_shipping; ?><?php echo $required_shipping ? '<abbr class="required" title="'.esc_attr__( 'required', 'woocommerce'  ).'">*</abbr>' : ''; ?></label><input id="shipping_city" class="input-text " type="text" value="" placeholder="<?php echo $placeholder_shipping; ?>" name="shipping_city"></p><?php echo $clear_shipping ? '<div class="clear"></div>' : '' ?>');
		} ).change();
	</script>
	<?php
}
add_action('woocommerce_after_checkout_billing_form','get_ajax_city_billing_fields_By_HANNANStd');
function get_ajax_city_billing_fields_By_HANNANStd(){
	wp_enqueue_script('ajax_billing_iran_cities',plugins_url('/js/billing.js',__FILE__), array('jquery'));
	wp_localize_script('ajax_billing_iran_cities','HANNANStd_Ajax_Billing_Cities',array('ajaxurl' => admin_url('admin-ajax.php') ,'nextNonce' => wp_create_nonce('hannanstd-next-nonce'))); ?>
	<script type="text/javascript">
		jQuery(document).ready(function(jQuery){billing_state();});
	</script>
	<?php
}
add_action('woocommerce_after_checkout_shipping_form','get_ajax_city_shipping_fields_By_HANNANStd');
function get_ajax_city_shipping_fields_By_HANNANStd(){
	wp_enqueue_script('ajax_shipping_iran_cities',plugins_url('/js/shipping.js',__FILE__), array('jquery'));
	wp_localize_script( 'ajax_shipping_iran_cities', 'HANNANStd_Ajax_Shipping_Cities', array('ajaxurl' => admin_url('admin-ajax.php'),'nextNonce' => wp_create_nonce('hannanstd-next-nonce')));	?>	
	<script type="text/javascript">
		jQuery(document).ready(function(jQuery){shipping_state();});
	</script>
	<?php
}


add_action('wp_ajax_get_cities_from_state_by_hannanstd','get_cities_from_state_by_hannanstd');
add_action('wp_ajax_nopriv_get_cities_from_state_by_hannanstd','get_cities_from_state_by_hannanstd');	
function get_cities_from_state_by_hannanstd() {
	$i_state_HS = sanitize_text_field($_GET['i_state']);
	$nextnonce = sanitize_text_field($_GET['nextNonce']);
	global $current_user;
	$user_id = $current_user ? $current_user->ID : 0;
	if ( $user_id and is_numeric($user_id) and $user_id > 0 ) {
		$billing_city = get_user_meta( $user_id, 'billing_city', true ) ? get_user_meta( $user_id, 'billing_city', true ) : 'شهر';	
		$shipping_city = get_user_meta( $user_id, 'shipping_city', true ) ? get_user_meta( $user_id, 'shipping_city', true ) : 'شهر';	
	}
	else {
		$billing_city = 'شهر';	
		$shipping_city = 'شهر';	
	}
	if(!wp_verify_nonce($nextnonce,'hannanstd-next-nonce'))
			die('Invalid Invocation');
	$li_city = array();
	if(!empty($i_state_HS)) {
		$li_city = get_cities_by_hannanstd($i_state_HS);
		echo $billing_city.';';	
		echo $shipping_city.';';	
	}
	foreach( (array) $li_city as $value){
		echo trim($value).';';
	}
}

function get_cities_by_hannanstd ($i_state_HS){
	global $wpdb;		
	$table = $wpdb->prefix . 'Woo_Iran_Cities_By_HANNANStd';
	$i_state_HS = sanitize_text_field(trim($i_state_HS));
	if ($i_state_HS === ''){
		return null;
	}
	if ($i_state_HS === 'init'){
		$city_return [''] = '';
		return $city_return;
	}
	$var = '_'.$i_state_HS.'_';
	$city = $wpdb->get_results($wpdb->prepare("SELECT `city` FROM {$table} WHERE `state` LIKE '%%%s%%' ", $var ));
	$city = json_decode(json_encode($city),true);
	$city_return = array();
	foreach( (array) $city as $value){
		$city_return [$value['city']] = $value['city'];	
	}
	return $city_return;
}