<?php
$atts = shortcode_atts(array(
    "label" => false,
), $atts);

$contactDB = Iw_Helper_DB_Manager::options("get", "company-front-info");
if (empty($contactDB) || !is_array($contactDB)) return '';

$output = '<ul class="iw-contact-info">';

foreach ($contactDB as $contactMethod => $contactMethodInfo) {
    $output .= '<li class="' . esc_attr($contactMethod) . '">';

    if ($atts["label"]) {
        $output .= '<' . esc_html($atts["label"]) . '>' . esc_html($contactMethodInfo["label"]) . '</' . esc_html($atts["label"]) . '>';
    }

    $output .= '<ul>';
    if (!empty($contactMethodInfo["content"])) {
        foreach ($contactMethodInfo["content"] as $contactInfo) {
            $href = esc_url($contactInfo["href"]);
            $label = esc_html($contactInfo["label"]);
            $icon_name = esc_attr($contactInfo["icon-class"]);

            // Rutas de posibles iconos
            $plugin_icon_path = get_plugin_directory() . "assets/img/icons/" . $icon_name;
            $custom_icon_path = get_custom_helper_directory() . "/assets/img/icons/" . $icon_name;

            // Verificamos cuál existe
            if (file_exists($plugin_icon_path)) {
                $icon_url = esc_url(get_plugin_url() . "assets/img/icons/" . $icon_name);
            } elseif (file_exists($custom_icon_path)) {
                $icon_url = esc_url(get_custom_helper_url() . "/assets/img/icons/" . $icon_name);
            } else {
                $icon_url = ""; // No existe icono
            }

            // Construimos el <li>
            $output .= '<li><a target="_blank" href="' . $href . '">';
            if (!empty($icon_url)) {
                $output .= '<img src="' . $icon_url . '" alt="' . $label . '">';
            }
            $output .= $label . '</a></li>';
        }
    }

    $output .= '</ul>';

    $output .= '</li>';
}

$output .= '</ul>';

return $output;

/*
add_shortcode("iw-display-contact-info", function($atts) {
    
});
*/