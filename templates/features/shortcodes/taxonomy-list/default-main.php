<?php
/**
 * Template: taxonomy-list.php
 * Variables disponibles:
 * $taxonomy, $terms, $depth
 */
?>
<?php if ($part == "container-open") : ?>
    <div class="taxonomy-list-container <?php echo $taxonomy; ?>-list-container">
        <ul class="taxonomy-list <?php echo $taxonomy; ?>-list">
<?php elseif ($part == "container-close") : ?>
        </ul>
    </div>
<?php elseif ($part == "child-has-children-open") : ?>
        <li>
            <a href="<?php echo $term_url; ?>"><?php echo $term_name; ?></a>
            <ul>
<?php elseif ($part == "child-has-children-close") : ?>
            </ul>
        </li>
<?php elseif ($part == "child-single") : ?>
        <li>
            <a href="<?php echo $term_url; ?>"><?php echo $term_name; ?></a>
        </li>
<?php endif; ?>