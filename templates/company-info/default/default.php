<?php
/**
 * Template: contact-info.tpl
 * Variables esperadas:
 *   - $contactDB : array con los métodos de contacto
 *   - $label_tag : etiqueta HTML a usar para el título de cada método de contacto (opcional)
 */
?>

<ul class="iw-contact-info">
    <?php foreach ($contactDB as $contactMethod => $contactMethodInfo) : ?>
        <li class="<?php echo esc_attr($contactMethod); ?>">

            <?php if (!empty($label_tag)) : ?>
                <<?= esc_html($label_tag) ?>>
                    <?= esc_html($contactMethodInfo['label']) ?>
                </<?= esc_html($label_tag) ?>>
            <?php endif; ?>

            <ul>
                <?php if (!empty($contactMethodInfo['content'])) : ?>
                    <?php foreach ($contactMethodInfo['content'] as $contactInfo) : ?>
                        <li>
                            <a class="<?= esc_html($contactInfo["icon-class"]) ?>" target="_blank" href="<?= esc_url($contactInfo['href']) ?>">
                                <?= esc_html($contactInfo['label']) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </li>
    <?php endforeach; ?>
</ul>
