<?php
/*
 * 
 * Create a custom Shortcode
 * 
 */
?>

<?php
function custom_shortcode() { 
 
	$output .= '<div>';
						
	$output .=	WC()->cart->get_cart_contents_count();

	$ouput .= '</div>';

	return $ouput;

}

add_shortcode('SHORTCODE_TITLE', 'custom_shortcode');