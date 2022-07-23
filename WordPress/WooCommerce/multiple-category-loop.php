<?php
/*
 *
 *  
 * 
 * 
*/

<ul class="items">
	<?php
    $args = array( 
		'post_type' => 'product',
		'tax_query' => array(
			'relation' => 'OR',
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => 'YOUR CATEGORY'
			),
			array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => 'YOUR CATEGORY'
			)
		),
		'posts_per_page' => '3'
	);
	
	$loop = new WP_Query( $args );
	$count = 0;

	while ( $loop->have_posts() ) : $loop->the_post(); global $product;
		$featured_img_url = get_the_post_thumbnail_url($loop->post->ID,'full'); ?>
		
        <?php $count = $count + 1; ?>
     
		<li class="item" onclick="window.location='<?php the_permalink(); ?>';">

			<p class="counter">
                [<?php if($count < 10) { echo '0'. $count; } elseif($count > 10) { echo $count; } ?>]
            </p>

			<h2><?php the_title(); ?></h2>
        </li>
 
        <?php endwhile; ?>
        <?php wp_reset_query(); ?>  
			   
</ul>