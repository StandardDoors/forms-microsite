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
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: '#008C3C',
                        'brand-mid': '#06AE42',
                        'brand-light': '#23A455',
                    },
                    fontFamily: {
                        sans: ['Helvetica Neue', 'Arial', 'sans-serif'],
                    },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #374151; line-height: 1.625; max-width: 64rem; margin: 0 auto; padding: 0 1rem; }
        h1   { font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: #111827; }
        h2   { font-size: 1.25rem; font-weight: 600; margin-bottom: 0.75rem; color: #1f2937; }
        p    { margin-bottom: 1rem; }
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
