<ul class="iw-contact-info">

<?php foreach ($contactDB as $contactMethod => $contactMethodInfo) : ?>
    <li class="<?php echo esc_attr($contactMethod)?>">

    <?php if ($label) {
        echo '<' . esc_html($label) . '>';
            echo esc_html($contactMethodInfo["label"]);
        echo '</' . esc_html($atts["label"]) . '>';
    }?>

    <ul>
    <?php if (!empty($contactMethodInfo["content"])) : ?>
        <?php foreach ($contactMethodInfo["content"] as $contactInfo) : ?>
            <?php
            $href = esc_url($contactInfo["href"]);
            $label = esc_html($contactInfo["label"]);
            $icon_name = esc_attr($contactInfo["icon-class"]);

            // Rutas de posibles iconos
            $plugin_icon_path = get_plugin_directory() . "assets/img/icons/" . $icon_name;

            // Verificamos cuál existe
            if (file_exists($plugin_icon_path)) {
                $icon_url = esc_url(get_plugin_url() . "assets/img/icons/" . $icon_name);
            }
            else {
                $icon_url = ""; // No existe icono
            }
            ?>

            <li><a target="_blank" href="' . $href . '">
            <?php if (!empty($icon_url)) : ?>
                <img src="' . $icon_url . '" alt="' . $label . '">
            <?php endif; ?>
            </a></li>
        <?php endforeach; ?>
    <?php endif; ?>
    </ul>
    </li>
<?php endforeach; ?>
</ul>