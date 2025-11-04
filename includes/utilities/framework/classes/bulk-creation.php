<?php

namespace IW_Helper\Utilities\Framework\Admin;

use Iw_Admin_Page_Manager;

class IW_Helper_Bulk_Creation {
    private static array $post_types;

    public static function add_dir($post_type) {
        self::$post_types[] = $post_type;
    }

    public static function init() {
        Iw_Admin_Page_Manager::add_page("Bulk Creation", "Bulk Creation", "edit_posts", "iw-bulk-creation", self::renderForm(), "dashicons-image-rotate");
        foreach (self::$base_dirs as $base_dir) {
            $post_type = ""; // Obtenido desde el dir
            $capabilities = get_post_type_object($post_type)->cap->publish_posts;
            Iw_Admin_Page_Manager::add_subpage();
        }
    }

    

    private static function renderForm($layout) {
        iw_load_template("framework/bulk-creation/form", array(

        ), $layout);
    }

    private static function renderField($layout) {
        iw_load_template("framework/bulk-creation/form", array(
            
        ), $layout);
    }
}











// Función para la página del submenú "Bulk Create Posts"
function bulk_create_pages_page() {
    // Comprobamos si el formulario ha sido enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bulk_posts'])) {
        bulk_create_pages($_POST['titles'], $_POST['extracts'], $_POST['contents']);
    }

    // Mostrar el formulario HTML
    ?>
    <div class="wrap">
        <h2>Generar publicaciones masivas</h2>
        <form method="post" action="">
            <div id="posts-container">
                <!-- Esqueleto oculto para la clonación -->
                <div class="post-entry" id="post-entry-template" style="display:none;">
                    <table class="form-table">
                        <tr>
                            <th><label for="titles">Título</label></th>
                            <td><input type="text" name="titles[]" class="regular-text" placeholder="Título de la publicación" /></td>
                        </tr>
                        <tr>
                            <th><label for="extracts">Extracto</label></th>
                            <td><input type="text" name="extracts[]" class="regular-text" placeholder="Extracto de la publicación" /></td>
                        </tr>
                        <tr>
                            <th><label for="contents">Contenido</label></th>
                            <td>
                                <textarea name="contents[]" class="regular-text" placeholder="Contenido de la publicación"></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                
                <!-- Clonación de la plantilla -->
                <div id="posts-container-dynamic">
                    <!-- Aquí se irán agregando las publicaciones dinámicamente -->
                </div>
            </div>
            <p><button type="button" id="add-post" class="button-secondary">Añadir otro post</button></p>
            <p class="submit">
                <input type="submit" name="bulk_posts" class="button-primary" value="Generar publicaciones">
            </p>
        </form>
    </div>
    <?php
}

// Función para crear las publicaciones masivas
function bulk_create_pages($titles, $extracts, $contents) {
    // Procesar los arrays y asegurarnos de que tengan el mismo número de elementos
    $num_posts = count($titles);
    $max_posts = max(count($extracts), count($contents));

    for ($i = 0; $i < $max_posts; $i++) {
        $post_data = array(
            'post_title'   => sanitize_text_field($titles[$i]),
            'post_excerpt' => sanitize_textarea_field($extracts[$i]),
            'post_content' => wp_kses_post($contents[$i]),
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
            'post_type'    => 'page'
        );
        wp_insert_post($post_data);
    }

    // Mensaje de confirmación
    echo '<div class="updated"><p>Las publicaciones han sido creadas correctamente.</p></div>';
}
