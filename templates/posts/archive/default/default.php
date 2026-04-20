<?= openContainer($container_tag, array(
	"id" => $container_id,
	"class" => "iw-post-list ".$post_type,
)) ?>
<?php if ($query->have_posts()) : ?>
    <?php while ($query->have_posts()) : $query->the_post() ?>
    	<?= openContainer($item_tag) ?>
        	<?= openContainer($header_tag) ?>
        		<a href="<?= esc_url(get_permalink()) ?>"><?= esc_html(get_the_title()) ?></a>
        		<p><?= esc_html(get_the_excerpt()) ?></p>
         	<?= closeContainer($header_tag) ?>
        <?= closeContainer($item_tag) ?>
    <?php endwhile; ?>
<?php else : ?>
    <p>No se encontraron resultados.</p>
<?php endif; ?>
<?= closeContainer($container_tag) ?>
<?php wp_reset_postdata(); ?>