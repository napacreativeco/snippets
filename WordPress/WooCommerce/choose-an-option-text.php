<?php

add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'cinchws_filter_dropdown_args', 10 );

function cinchws_filter_dropdown_args( $args ) {
    $args['show_option_none'] = 'Choose a size';
    return $args;
}