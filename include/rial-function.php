<?php



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
