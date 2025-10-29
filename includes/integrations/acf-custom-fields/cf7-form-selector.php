<?php
/**
 * cf7-selector.php
 *  Define el campo “Formulario (selector CF7)” para ACF Pro
 */
// Evita el acceso directo
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('acf_field_cf7_selector')) {
    class acf_field_cf7_selector extends acf_field {

        public function __construct() {
            $this->name     = 'cf7_form_selector';
            $this->label    = 'Formulario (selector CF7)';
            $this->category = 'relational';
            $this->defaults = array(
                'allow_null' => 0,
                'multiple'   => 0,
            );
            parent::__construct();
        }
    
        public function render_field_settings( $field ) {
            acf_render_field_setting( $field, array(
                'label'        => 'Permitir vacío',
                'type'         => 'true_false',
                'name'         => 'allow_null',
            ));
            acf_render_field_setting( $field, array(
                'label'        => 'Selección múltiple',
                'type'         => 'true_false',
                'name'         => 'multiple',
            ));
        }
    
        public function render_field( $field ) {
            $forms = get_posts( array(
                'post_type'      => 'wpcf7_contact_form',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ) );
    
            // Atributos básicos del <select>
            $attrs = '';
            $name  = esc_attr( $field['name'] );
            if ( $field['multiple'] ) {
                $attrs .= ' multiple';
                $name  .= '[]';
            }
    
            echo '<select name="'. $name .'" id="'. esc_attr($field['id']) .'"'. $attrs .'>';
            if ( $field['allow_null'] ) {
                echo '<option value="">– ninguno –</option>';
            }
    
            foreach ( $forms as $form ) {
                $shortcode = sprintf(
                    '[contact-form-7 id="%d" title="%s"]',
                    $form->ID,
                    esc_attr( $form->post_title )
                );
    
                $sel = '';
                if ( $field['value'] ) {
                    if ( is_array( $field['value'] ) ) {
                        $sel = in_array( $shortcode, $field['value'] ) ? ' selected' : '';
                    } else {
                        $sel = ( $field['value'] === $shortcode ) ? ' selected' : '';
                    }
                }
    
                printf(
                    '<option value="%s"%s>%s</option>',
                    esc_attr( $shortcode ),
                    $sel,
                    esc_html( $form->post_title )
                );
            }
    
            echo '</select>';
        }
    }
    
    // Finalmente, registramos la clase para que ACF la detecte
    new acf_field_cf7_selector();
}

