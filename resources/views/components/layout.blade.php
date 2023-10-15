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

    <footer class="mt-10 pb-5">
        {{ $footer ?? '' }}

        <div class="border-t border-zinc-200 dark:border-zinc-700 pt-5 mt-10 flex gap-x-4 text-sm">
            <div>Mert Hürtürk</div>
            <div class="opacity-50">&mdash;</div>
            <a target="_blank" href="https://x.com/merthurturk">X</a>
            <a target="_blank" href="https://instagram.com/merthurturk">Instagram</a>
            <a target="_blank" href="https://linkedin.com/in/merthurturk">LinkedIn</a>
        </div>
    </footer>
</section>
</body>
</html>
