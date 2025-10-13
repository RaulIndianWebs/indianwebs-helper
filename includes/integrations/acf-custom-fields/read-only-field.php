<?php
/**
 * read-on-y-field.php
 *  Define el campo Campo no editable (read only)” para ACF Pro
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('acf_field_read_only')) {
    class acf_field_read_only extends acf_field {

        public function __construct() {
            $this->name     = 'read_only';
            $this->label    = 'Campo no editable (read only)';
            $this->category = 'basic';
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
        }
    
        public function render_field( $field ) {
            $attrs = '';
            $name  = esc_attr( $field['name'] );
            $id    = esc_attr( $field['id'] );
            $value = esc_attr( $field['value'] ); // Escapamos el valor para seguridad
    
            echo '<input name="'. $name .'" id="'. $id .'" value="'. $value .'"'. $attrs .' readonly>';
        }
    }
    
    new acf_field_read_only();    
}
