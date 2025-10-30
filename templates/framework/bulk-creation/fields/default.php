<?php
/**
 * 
 * 
 * 
 */
?>

<?php if ($field["type"] == "text") : ?>
    <!-- Input de texto -->
<?php elseif ($field["type"] == "textarea") : ?>
    <!-- Textarea -->
<?php elseif ($field["type"] == "wysiwyg") : ?>
    <!-- Campo tipo WYSIWYG -->
<?php elseif ($field["type"] == "taxonomy") : ?>
    <?php if ($field["hierarchy"]) : ?>
        <?php post_categories_meta_box(get_default_post_to_edit($post_type), $field["box"]); ?>
    <?php else : ?>
        <?php post_tags_meta_box($field["taxonomy-name"], $field["box"]); ?>
    <?php endif; ?>
<?php endif; ?>