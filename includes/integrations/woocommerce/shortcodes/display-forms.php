<?php
add_shortcode("iw-display-woocommerce-form", function($atts) {
    $atts = shortcode_atts(array(
        'slug' => '',
    ), $atts);

    ob_start();

    switch ($atts["slug"]) {
        case 'login':
            ?>
            <form class="woocommerce-form woocommerce-form-login login iw-woocommerce-form" method="post" novalidate>
                <?php do_action('woocommerce_login_form_start'); ?>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="username"><?php esc_html_e('Username or email address', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" required />
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="password"><?php esc_html_e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" required />
                </p>
                <?php do_action('woocommerce_login_form'); ?>
                <p class="form-row">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php esc_html_e('Remember me', 'woocommerce'); ?>
                    </label>
                    <?php wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                    <button type="submit" class="woocommerce-button button" name="login" value="<?php esc_attr_e('Log in', 'woocommerce'); ?>"><?php esc_html_e('Log in', 'woocommerce'); ?></button>
                </p>
                <p class="woocommerce-LostPassword lost_password">
                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
                </p>
                <p>
                <?php do_action('woocommerce_login_form_end'); ?>
            </form>
            <?php
            break;

        case 'register':
            if ('yes' === get_option('woocommerce_enable_myaccount_registration')) :
            ?>
            <form method="post" class="woocommerce-form woocommerce-form-register register iw-woocommerce-form" novalidate>
                <?php do_action('woocommerce_register_form_start'); ?>
                <?php if ('no' === get_option('woocommerce_registration_generate_username')) : ?>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_username"><?php esc_html_e('Username', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" required />
                </p>
                <?php endif; ?>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_email"><?php esc_html_e('Email address', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" required />
                </p>
                <?php if ('no' === get_option('woocommerce_registration_generate_password')) : ?>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_password"><?php esc_html_e('Password', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" required />
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label for="reg_password_confirm"><?php esc_html_e('Confirma Contrasñea', 'woocommerce'); ?> <span class="required">*</span></label>
                    <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password_confirm" id="reg_password_confirm" autocomplete="new-password" required />
                </p>
                <?php else : ?>
                <p><?php esc_html_e('A link to set a new password will be sent to your email address.', 'woocommerce'); ?></p>
                <?php endif; ?>
                <?php do_action('woocommerce_register_form'); ?>
                <p class="woocommerce-form-row form-row">
                    <?php wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                    <button type="submit" class="woocommerce-Button woocommerce-button button" name="register" value="<?php esc_attr_e('Register', 'woocommerce'); ?>"><?php esc_html_e('Register', 'woocommerce'); ?></button>
                </p>
                <?php do_action('woocommerce_register_form_end'); ?>
            </form>
            <?php
            else:
                echo '<p>' . esc_html__('El registro está desactivado.', 'woocommerce') . '</p>';
            endif;
            break;

        default:
            echo '<p>' . esc_html__('El formulario no existe.', 'woocommerce') . '</p>';
            break;
    }

    return ob_get_clean();
});



IW_Scripts_Cache::cache_css_files(get_plugin_directory() . 'assets/css/shortcodes/woocommerce/woocommerce-forms.css');
