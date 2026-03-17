<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Standard Doors – Forms</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-brand: #008C3C;
            --font-sans: 'Helvetica Neue', Arial, sans-serif;
        }
        @layer base {
            body { @apply font-sans text-gray-700 leading-relaxed max-w-5xl mx-auto px-4; }
        }
    </style>
</head>
<body>
    <main>
        <div class="flex justify-center gap-8 mt-16">
            <a href="/en/" class="block px-12 py-8 no-underline text-brand border-2 border-brand rounded-lg text-xl font-semibold hover:bg-brand hover:text-white transition-colors">English</a>
            <a href="/fr/" class="block px-12 py-8 no-underline text-brand border-2 border-brand rounded-lg text-xl font-semibold hover:bg-brand hover:text-white transition-colors">Français</a>
        </div>
    </main>
</body>
</html>
