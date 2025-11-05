<?php
/**
 * 
 * 
 */
if (empty($tabs)) return;

$current_tab = $_GET['tab'] ?? array_key_first($tabs);
?>

<h2 class="nav-tab-wrapper">
<?php foreach ($tabs as $slug => $tab) : ?>
    <a href="<?= esc_url($tab["link"]["url"]) ?>" class="nav-tab <?= $current_tab === $slug ? ' nav-tab-active' : '' ?>"><?= esc_html($tab["link"]["label"]) ?></a>
<?php endforeach; ?>
</h2>

<main>
    <?= $tabs[$current_tab]["content"] ?>
</main>