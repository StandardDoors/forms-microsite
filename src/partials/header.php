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
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-brand: #008C3C;
            --color-brand-mid: #06AE42;
            --color-brand-light: #23A455;
            --font-sans: 'Helvetica Neue', Arial, sans-serif;
        }
        @layer base {
            body  { @apply font-sans text-gray-700 leading-relaxed max-w-5xl mx-auto px-4; }
            h1    { @apply text-2xl font-bold mb-4 text-gray-900; }
            h2    { @apply text-xl font-semibold mb-3 text-gray-800; }
            p     { @apply mb-4; }
        }
    </style>
</head>
<body>
    <header class="border-b-2 border-brand py-4 mb-8">
        <nav class="flex items-center gap-6">
            <a href="/<?php echo $lang; ?>/">
                <img src="/assets/logos/Standard-Logo-50-years-Colour.png" alt="<?php echo $siteName; ?>" class="h-10 w-auto">
            </a>
            <div class="flex gap-6">
                <a href="/<?php echo $lang; ?>/" class="text-brand font-medium no-underline hover:underline"><?php echo $t['nav.home']; ?></a>
                <a href="/<?php echo $lang; ?>/service/" class="text-brand font-medium no-underline hover:underline"><?php echo $t['nav.service']; ?></a>
                <a href="/<?php echo $lang; ?>/find-your-production-number/" class="text-brand font-medium no-underline hover:underline"><?php echo $t['nav.find_product']; ?></a>
            </div>
            <a href="<?php echo $altUrl; ?>" class="ml-auto px-3 py-1 border border-brand rounded text-sm text-brand no-underline hover:bg-brand hover:text-white transition-colors"><?php echo $t['lang.toggle']; ?></a>
        </nav>
    </header>
    <main class="min-h-[60vh] pb-8">
