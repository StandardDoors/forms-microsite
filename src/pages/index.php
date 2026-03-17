<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Standard Doors – Forms</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { brand: '#008C3C' },
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #374151; line-height: 1.625; max-width: 64rem; margin: 0 auto; padding: 0 1rem; }
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
