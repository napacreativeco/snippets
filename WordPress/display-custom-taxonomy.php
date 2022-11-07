<?php
/*
 * Display Taxonomy
 * Shows the 'name' of a custom taxonomy attached to a post
 * 
*/
    $term_list = wp_get_post_terms( $post->ID, 'YOUR_TAXONOMY', array( 'fields' => 'all' ) );
    
    $terms = get_the_terms( $post->ID, 'YOUR_TAXONOMY' );

    foreach($terms as $term) {
    
        echo '<p>'. $term->name .'</p>';
    
    }
?>