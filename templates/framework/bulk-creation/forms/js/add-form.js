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