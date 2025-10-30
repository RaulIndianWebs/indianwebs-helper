<?php
/**
 * Template: taxonomy-list.php
 * Variables disponibles:
 * $taxonomy, $terms, $depth
 */
?>
<div class="taxonomy-list-container">
    <ul class="taxonomy-list">
        <?php iw_render_taxonomy_items($taxonomy, $terms, $depth); ?>
    </ul>
</div>
