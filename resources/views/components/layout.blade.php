@props(['title'])
<!doctype html>
<html lang="en">
<head>
    <title>{{ $title ?? 'Mert Hürtürk' }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <script defer data-domain="intromert.com" src="https://plausible.io/js/script.js"></script>

    <script defer src="https://unpkg.com/@alpinejs/ui@3.13.1-beta.0/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/@alpinejs/focus@3.13.1/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.13.1/dist/cdn.min.js"></script>
</head>
<body class="p-5 md:p-10 bg-white dark:bg-zinc-800">
<section class="prose dark:prose-invert prose-zinc mx-auto hover:prose-a:text-rose-600">
    {{ $slot }}

    <footer class="mt-10 pb-5">
        {{ $footer ?? '' }}

        <div class="border-t border-zinc-200 dark:border-zinc-700 pt-5 mt-10 flex gap-x-4 text-sm">
            <div>&copy;{{ now()->year }} Mert Hürtürk. All rights reserved.</div>
            <div class="opacity-50">&mdash;</div>
            <a target="_blank" href="https://x.com/merthurturk">X</a>
            <a target="_blank" href="https://instagram.com/merthurturk">Instagram</a>
            <a target="_blank" href="https://linkedin.com/in/merthurturk">LinkedIn</a>
        </div>
    </footer>
</section>
</body>
</html>
