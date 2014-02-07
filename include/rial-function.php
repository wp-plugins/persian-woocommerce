<?php
/*
Plugin Name: Rial Currency Woocommerce
Plugin URI: http://woocommerce.ir/
Description: با استفاده از این افزونه قادر هستید براحتی واحد پولی ریال را به واحد های پولی ووکامرس اضافه کنید
Version: 1.2
Author: Mohammad Majidi
Author URI: http://woocommerce.ir
*/


add_filter( 'woocommerce_currencies', 'add_my_currency' );

 

function add_my_currency( $currencies ) {

$currencies['IRR'] = __( 'ریال', 'woocommerce' );
$currencies['IRT'] = __( 'تومان', 'woocommerce' );

return $currencies;

}

add_filter('woocommerce_currency_symbol', 'add_my_currency_symbol', 10, 2);

 

function add_my_currency_symbol( $currency_symbol, $currency ) {

switch( $currency ) {

case 'IRR': $currency_symbol = 'ریال'; break;
case 'IRT': $currency_symbol = 'تومان'; break;

}

return $currency_symbol;

}


?>
