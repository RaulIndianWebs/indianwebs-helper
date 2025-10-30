<?php
/**
 * 
 * 
 */
?>
<<?php echo $container_tag; ?> id="$container_id" class="iw-post-list">
<?php if ($query->have_posts()) : ?>
    <?php while ($query->have_posts()) : $query->the_post(); ?>
        <<?php echo $item_tag; ?>>
            <a href="<?php echo esc_url(get_permalink()); ?>">
                <<?php echo $header_tag; ?>> <?php echo get_the_title(); ?></ <?php echo $header_tag; ?>>
            </a>
        </<?php echo $item_tag; ?>>
        <?php wp_reset_postdata(); ?>
    <?php endwhile; ?>
<?php else : ?>
     <p>No se encontraron resultados.</p>
<?php endif; ?>
</<?php echo $container_tag; ?>>
