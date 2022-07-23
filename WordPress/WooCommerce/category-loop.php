<ul>
    <?php
    $args = array( 
        'post_type' => 'product',
        'product_cat' => 'goods',
    );

    $loop = new WP_Query( $args );
    
    while ( $loop->have_posts() ) : $loop->the_post(); global $product;
        $featured_img_url = get_the_post_thumbnail_url($loop->post->ID,'full'); ?>
    
        <li>
            <?php the_content(); ?>
        </li>

    <?php endwhile; ?>

    <?php wp_reset_query(); ?>  
			   
</ul>