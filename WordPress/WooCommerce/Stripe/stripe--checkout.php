<?
// Stripe provides a filter for you to add custom Stripe Elements Styling
// See full documentation from Stripe on what elements are available to be styled here:
// https://stripe.com/docs/stripe-js/reference#element-options

add_filter( 'wc_stripe_elements_styling', 'woogist_add_stripe_elements_styles' );
function woogist_add_stripe_elements_styles($array) {
	$array = array(
		'base' => array( 
			'color' 	=> 'var(--black)',
			'colorText' => 'var(--black)',
			'fontFamily' 	=> 'PP Supply Mono',
			'fontSize' 	=> '1rem',
			'::placeholder' => array(
                'color' => '#000',
				'opacity' => '0'
			),
		),
		
		'invalid' => array(
			'color'		=> 'var(--red)'
		)
	);
	return $array;
}