<?php
// Textos legales
$atts = shortcode_atts(array(
    'contenido' => '',
), $atts);

$datosArray = getPluginOptions("company-legal-info");

$placeholders = [
    '{{site_url}}'                      => esc_url($datosArray["site_url"]),
    '{{site_name}}'                     => esc_html($datosArray["site_name"]),
    '{{titular}}'                       => esc_html($datosArray["titular"]),
    '{{nif}}'                           => esc_html($datosArray["nif"]),
    '{{telefono}}'                      => esc_html($datosArray["telefono"]),
    '{{email}}'                         => esc_html($datosArray["email"]),
    '{{direccion}}'                     => esc_html($datosArray["direccion"]),
    '{{pais}}'                          => esc_html($datosArray["pais"]),
    '{{descripcion_productos}}'         => esc_html($datosArray["descripcion_productos"]),
    '{{texto_boton_compra}}'                          => esc_html($datosArray["texto_boton_compra"]),
    '{{envio}}'                          => esc_html($datosArray["envio"]),
    '{{formulario_devoluciones}}'                          => esc_url($datosArray["formulario_devoluciones"]),
];


$output = '';

$template_path = get_plugin_directory() . 'includes/textos-legales/'.$atts["contenido"].'.html';
if (!file_exists($template_path)) {
    return '<p>La plantilla legal no se encontró.</p>';
}

$template = file_get_contents($template_path);
$output = str_replace(array_keys($placeholders), array_values($placeholders), $template);

return $output;




/*
add_shortcode('iw-textos-legales', function ($atts) {
    
});*/