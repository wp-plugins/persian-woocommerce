<?php


function woocommerce_persian_widget(){
	$widget_options = woocommerce_persian_widgetoptions();
	echo '<div class="rss-widget">';
		wp_widget_rss_output(array(
			'url' => 'http://woocommerce.ir/feed.xml',
			'title' => 'آخرین اخبار و اطلاعیه های ووکامرس پارسی',
			'meta' => array( 'target' => '_new' ),
			'items' => $widget_options['posts_number'],
            		'show_summary' => 1, 
            		'show_author' => 0, 
           		'show_date' => 1 
		));
	?>
		<div style="border-top: 1px solid #e7e7e7; padding-top: 12px !important; font-size: 12px;">
		<?php echo '<img src="' . plugins_url( 'images/feed.png' , __FILE__ ) . '" width="16" height="16" > '; ?>
			<a href="http://woocommerce.ir" target="_new" title="خانه">وب سایت پشتیبان ووکامرس پارسی</a> 
			

 		</div>
	<?php
	echo "</div>";
}
function woocommerce_persian_widgetshow() {
	
	wp_add_dashboard_widget('woocommerce_persian_feed', 'آخرین اخبار و اطلاعیه های ووکامرس پارسی', 'woocommerce_persian_widget', 'wp98_widset_pw' );

}
function woocommerce_persian_widgetoptions() {	
	$defaults = array( 'posts_number' => 3 );
	if ( ( !$options = get_option( 'woocommerce_persian_feed' ) ) || !is_array($options) )
		$options = array();
	return array_merge( $defaults, $options );
}
function wp98_widset_pw() {
	$options = woocommerce_persian_widgetoptions();
	if ( 'post' == strtolower($_SERVER['REQUEST_METHOD']) && isset( $_POST['widget_id'] ) && 'woocommerce_persian_feed' == $_POST['widget_id'] ) {
		foreach ( array( 'posts_number' ) as $key )
				$options[$key] = $_POST[$key];
		update_option( 'woocommerce_persian_feed', $options );
	}
?>
 
		<p>
			<label for="posts_number">تعداد نوشته های قابل نمایش در ابزارک ووکامرس پارسی:
				<select id="posts_number" name="posts_number">
					<?php for ( $i = 3; $i <= 20; $i = $i + 1 )
						echo "<option value='$i'" . ( $options['posts_number'] == $i ? " selected='selected'" : '' ) . ">$i</option>";
						?>
					</select>
				</label>
 		</p>
 
<?php
 }
add_action('wp_dashboard_setup', 'woocommerce_persian_widgetshow' );

?>
