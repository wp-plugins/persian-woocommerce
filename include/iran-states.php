<?php

/**
 * Iranian states
 *
 * @author 		woocommerce.ir
 * @version     1.0
 */




function  iran_states( $states ) {


$states['IR'] = array(
	'AL'  => __( 'البرز', 'woocommerce' ),
	'AR'  => __( 'اردبيل', 'woocommerce' ),
	'AE'  => __( 'آذربايجان شرقي', 'woocommerce' ),
	'AW'  => __( 'آذربايجان غربي', 'woocommerce' ),
	'BU'  => __( 'بوشهر', 'woocommerce' ),
	'CM'  => __( 'چهارمحال و بختياري', 'woocommerce' ),
	'FA'  => __( 'فارس', 'woocommerce' ),
	'GI'  => __( 'گيلان', 'woocommerce' ),
	'GO'  => __( 'گلستان', 'woocommerce' ),
	'HD'  => __( 'همدان', 'woocommerce' ),
	'HG'  => __( 'هرمزگان', 'woocommerce' ),
	'IL'  => __( 'ايلام', 'woocommerce' ),
	'IS'  => __( 'اصفهان', 'woocommerce' ),
	'KE'  => __( 'کرمان', 'woocommerce' ),
	'BK'  => __( 'کرمانشاه', 'woocommerce' ),
	'KS'  => __( 'خراسان شمالي', 'woocommerce' ),
	'KV'  => __( 'خراسان رضوي', 'woocommerce' ),
	'KJ'  => __( 'خراسان جنوبي', 'woocommerce' ),
	'KZ'  => __( 'خوزستان', 'woocommerce' ),
	'KB'  => __( 'کهگيلويه و بويراحمد', 'woocommerce' ),
	'KD'  => __( 'کردستان', 'woocommerce' ),
	'LO'  => __( 'لرستان', 'woocommerce' ),
	'MK'  => __( 'مرکزي', 'woocommerce' ),
	'MN'  => __( 'مازندران', 'woocommerce' ),
	'QZ'  => __( 'قزوين', 'woocommerce' ),
	'QM'  => __( 'قم', 'woocommerce' ),
	'SM'  => __( 'سمنان', 'woocommerce' ),
	'SB'  => __( 'سيستان و بلوچستان', 'woocommerce' ),
	'TE'  => __( 'تهران', 'woocommerce' ),
	'YA'  => __( 'يزد', 'woocommerce' ),
	'ZA'  => __( 'زنجان', 'woocommerce' ),
	
);
    return $states;

}

add_filter( 'woocommerce_states', 'iran_states' );
