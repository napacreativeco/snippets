<?php
if ( ! function_exists( 'myfirsttheme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function usal_theme_setup() {
	
	wp_enqueue_script( 'jquery' );
    wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_script( 'script', get_template_directory_uri() . '/assets/script.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'luxy', get_template_directory_uri() . '/vendor/luxy.min.js', array ( 'jquery' ), 1.1, true);
    wp_enqueue_script( 'lodash', get_template_directory_uri() . '/vendor/lodash.js', array ( 'jquery' ), 1.1, true);
	
    load_theme_textdomain( 'usalproject', get_template_directory() . '/languages' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array ( 'aside', 'gallery', 'quote', 'image', 'video' ) );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'woocommerce' );
	
    register_nav_menus(
        array(
        'large-menu' => __( 'Large Menu' ),
        'footer-menu' => __( 'Footer Menu' )
        )
    );
    
}
endif;
add_action( 'after_setup_theme', 'usal_theme_setup' );