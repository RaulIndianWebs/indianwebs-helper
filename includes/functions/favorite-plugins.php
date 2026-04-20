<?php
function render_fav_plugins( $fav_plugins ) {
    require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    require_once ABSPATH . 'wp-admin/includes/class-language-pack-upgrader.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/misc.php';

    $language_upgrader = new Language_Pack_Upgrader( new Automatic_Upgrader_Skin() );
    $language_upgrader->bulk_upgrade();

    $should_reload = false;

    if ( isset($_POST['bulk_install']) && !empty($_POST['bulk_plugins']) && check_admin_referer('install_fav_plugin') ) {
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/misc.php';

        foreach ( (array) $_POST['bulk_plugins'] as $slug ) {
            $slug = sanitize_text_field($slug);
            $installed_plugins = get_plugins();
            $plugin_file = null;
            foreach ( $installed_plugins as $file => $data ) {
                if ( strpos($file, $slug . '/') === 0 ) {
                    $plugin_file = $file;
                    break;
                }
            }

            if ( $plugin_file ) {
                if ( ! is_plugin_active($plugin_file) ) {
                    activate_plugin($plugin_file);
                    $should_reload = true;
                    echo '<div class="updated"><p>✅ Activado: <strong>' . esc_html($installed_plugins[$plugin_file]['Name']) . '</strong></p></div>';
                } else {
                    echo '<div class="notice notice-info"><p>ℹ️ El plugin <strong>' . esc_html($installed_plugins[$plugin_file]['Name']) . '</strong> ya está activo.</p></div>';
                }
            } else {
                $api = plugins_api('plugin_information', [
                    'slug'   => $slug,
                    'fields' => ['sections' => false, 'icons' => true]
                ]);
                if ( ! is_wp_error($api) ) {
                    $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
                    $result   = $upgrader->install($api->download_link);
                    if ( $result ) {
                        $installed_plugins = get_plugins();
                        foreach ( $installed_plugins as $file => $data ) {
                            if ( strpos($file, $slug . '/') === 0 ) {
                                activate_plugin($file);
                                $language_upgrader = new Language_Pack_Upgrader( new Automatic_Upgrader_Skin() );
                                $language_upgrader->bulk_upgrade();
                                $should_reload = true;
                                echo '<div class="updated"><p>✅ Instalado y activado: <strong>' . esc_html($api->name) . '</strong></p></div>';
                                break;
                            }
                        }
                    } else {
                        echo '<div class="error"><p>❌ Error al instalar: ' . esc_html($slug) . '</p></div>';
                    }
                } else {
                    echo '<div class="error"><p>❌ No se pudo obtener información de: ' . esc_html($slug) . '</p></div>';
                }
            }
        }

        if ( $should_reload ) {
            echo '<script>window.location.href = window.location.href;</script>';
        }
    }

    ?>
    <div class="wrap">
        <form method="post">
            <?php wp_nonce_field('install_fav_plugin'); ?>
            <table class="wp-list-table widefat plugins striped">
                <thead>
                    <tr>
                        <td id="cb" width="5%" class="manage-column column-cb check-column" style="text-align:center;">
                            <input type="checkbox" id="cb-select-all">
                        </td>
                        <th scope="col" width="5%" style="text-align:center;">Icono</th>
                        <th scope="col" width="45%">Nombre</th>
                        <th scope="col" width="45%">Detalles</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ( $fav_plugins as $internal_name => $slug ):

                        $cache_key   = 'fav_plugin_info_' . sanitize_key($slug);
                        $plugin_info = get_transient($cache_key);

                        if ( false === $plugin_info ) {
                            $plugin_info = plugins_api('plugin_information', [
                                'slug'   => $slug,
                                'fields' => [
                                    'short_description' => false,
                                    'sections'          => false,
                                    'banners'           => false,
                                    'reviews'           => false,
                                    'downloaded'        => false,
                                    'active_installs'   => false,
                                    'ratings'           => false,
                                    'homepage'          => false,
                                    'tags'              => false,
                                    'contributors'      => false,
                                    'icons'             => true,
                                ]
                            ]);

                            if ( ! is_wp_error($plugin_info) ) {
                                set_transient($cache_key, $plugin_info, WEEK_IN_SECONDS);
                            }
                        }

                        $installed_plugins = get_plugins();
                        $plugin_file = null;
                        $status = 'No instalado';
                        $row_color = '#fdd'; // rojo por defecto

                        foreach ( $installed_plugins as $file => $data ) {
                            if ( strpos($file, $slug . '/') === 0 ) {
                                $plugin_file = $file;
                                if ( is_plugin_active($plugin_file) ) {
                                    $status = 'Activo';
                                    $row_color = '#d4fdd4'; // verde
                                } else {
                                    $status = 'Instalado';
                                    $row_color = '#f1f1f1'; // gris
                                }
                                break;
                            }
                        }

                        $display_name = !is_wp_error($plugin_info) && !empty($plugin_info->name) ? $plugin_info->name : $internal_name;

                        $icon_url = '';
                        if ( ! is_wp_error($plugin_info) && !empty($plugin_info->icons) ) {
                            $icon_url = $plugin_info->icons['2x'] 
                                    ?? $plugin_info->icons['1x'] 
                                    ?? $plugin_info->icons['default'] 
                                    ?? '';
                        }
                        ?>
                        <tr style="background-color: <?php echo esc_attr($row_color); ?>;">
                            <th scope="row" class="check-column" style="text-align:center;vertical-align:middle;padding:0;">
                                <input type="checkbox" name="bulk_plugins[]" value="<?php echo esc_attr($slug); ?>" style="margin:0;">
                            </th>
                            <td style="width:60px; text-align:center;vertical-align:middle;">
                                <?php if ( $icon_url ) : ?>
                                    <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($display_name); ?>" style="width:48px;height:48px;object-fit:contain;border-radius:6px;" />
                                <?php else: ?>
                                    <span style="display:inline-block;width:48px;height:48px;line-height:48px;text-align:center;background:#f1f1f1;border-radius:6px;color:#888;">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="plugin-title strong" style="vertical-align:middle;"><strong><?php echo esc_html($display_name); ?></strong></td>
                            <td style="vertical-align:middle;">
                                <strong>Versión:</strong> <?php echo !is_wp_error($plugin_info) && !empty($plugin_info->version) ? esc_html($plugin_info->version) : '-'; ?><br>
                                <strong>Autor:</strong> <?php echo !is_wp_error($plugin_info) && !empty($plugin_info->author) ? $plugin_info->author : '-'; ?><br>
                                <strong>Estado:</strong> <?php echo esc_html($status); ?><br>
                                <?php if ( ! is_wp_error($plugin_info) ) : ?>
                                    <a href="<?php echo esc_url(
                                        network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $slug . '&TB_iframe=true&width=900&height=600' )
                                    ); ?>" class="thickbox open-plugin-details-modal">Más detalles</a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>
                <button type="submit" name="bulk_install" class="button button-primary">Instalar / Activar seleccionados</button>
            </p>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const cbAll = document.getElementById('cb-select-all');
        if (cbAll) {
            cbAll.addEventListener('change', function() {
                document.querySelectorAll('input[name="bulk_plugins[]"]').forEach(cb => cb.checked = cbAll.checked);
            });
        }
    });
    </script>
    <?php
}

