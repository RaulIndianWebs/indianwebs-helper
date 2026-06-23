<?php
// Crear el submenú para "Posts"
add_action('admin_menu', function () {
    add_submenu_page(
        'bulk-creation',
        'Bulk Create Posts',
        'Posts',
        'manage_options',
        'bulk-create-posts',
        'bulk_create_posts_page',
    );
});



// Función para la página del submenú "Bulk Create Posts"
function bulk_create_posts_page() {
    // Comprobamos si el formulario ha sido enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['bulk_posts'])) {
        bulk_create_posts($_POST['titles'], $_POST['extracts'], $_POST['contents']);
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
    <script type="text/javascript">
        var postEntriesContainer = document.getElementById('posts-container-dynamic'); // Contenedor dinámico

        // Función para añadir un nuevo post
        document.getElementById('add-post').addEventListener('click', function() {
            var template = document.getElementById('post-entry-template');
            var newPost = template.cloneNode(true); // Clonamos el esqueleto oculto
            newPost.style.display = 'block'; // Mostramos el nuevo bloque

            var postCount = postEntriesContainer.getElementsByClassName('post-entry').length + 1; // Contamos los posts ya existentes

            // Actualizamos los names de los campos con un índice
            var titleInput = newPost.querySelector('input[name="titles[]"]');
            titleInput.name = 'titles[' + postCount + ']';

            var extractInput = newPost.querySelector('input[name="extracts[]"]');
            extractInput.name = 'extracts[' + postCount + ']';

            var contentTextarea = newPost.querySelector('textarea[name="contents[]"]');
            contentTextarea.name = 'contents[' + postCount + ']';

            postEntriesContainer.appendChild(newPost); // Añadimos el nuevo bloque al contenedor

            // Inicializar el editor WYSIWYG para el nuevo campo de contenido
            wp.editor.initialize(contentTextarea.id, {
                'textarea_name': 'contents[' + postCount + ']',
                'media_buttons': false,
                'textarea_rows': 10,
                'editor_class': 'wp-editor-area'
            });
        });
    </script>
    <?php
}

// Función para crear las publicaciones masivas
function bulk_create_posts($titles, $extracts, $contents) {
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
            'post_type'    => 'post'
        );
        wp_insert_post($post_data);
    }

    // Mensaje de confirmación
    echo '<div class="updated"><p>Las publicaciones han sido creadas correctamente.</p></div>';
}