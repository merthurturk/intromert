@props(['title'])
<!doctype html>
<html lang="en">
<head>
    <title>{{ $title ?? 'Mert Hürtürk' }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <!-- Fathom - beautiful, simple website analytics -->
    <script src="https://cdn.usefathom.com/script.js" data-site="JXHAIISH" defer></script>
    <!-- / Fathom -->
</head>
<body class="p-5 md:p-10 bg-white dark:bg-zinc-800">
<section class="prose dark:prose-invert prose-zinc mx-auto hover:prose-a:text-rose-600">
    {{ $slot }}

    <footer class="border-t border-zinc-200 mt-10 pb-5">
        {{ $footer ?? '' }}
    </footer>
</section>
</body>
</html>
