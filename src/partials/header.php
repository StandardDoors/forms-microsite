<?php

// Load translations and config (available to all pages via include).
$t = require __DIR__ . '/../i18n/' . ($lang ?? 'en') . '.php';
$config = require __DIR__ . '/../config.php';
$langConfig = $config[$lang] ?? $config['en'];
$siteName = $langConfig['site_name'];

// Compute alternate language URL
$altLang = $t['lang.alt_code'];
$altUrl = '/' . $altLang . ($pagePath ?? '/');

?><!DOCTYPE html>
<html lang="<?php echo $lang ?? 'en'; ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo ($pageTitle ?? $siteName); ?> – <?php echo $siteName; ?></title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
    <header>
        <nav>
            <div class="nav-links">
                <a href="/<?php echo $lang; ?>/"><?php echo $t['nav.home']; ?></a>
                <a href="/<?php echo $lang; ?>/service/"><?php echo $t['nav.service']; ?></a>
<a href="/<?php echo $lang; ?>/find-your-production-number/"><?php echo $t['nav.find_product']; ?></a>
            </div>
            <a href="<?php echo $altUrl; ?>" class="lang-toggle"><?php echo $t['lang.toggle']; ?></a>
        </nav>
    </header>
    <main>
