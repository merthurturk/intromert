<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use function App\convertToFileArray;
use function Laravel\Folio\render;

render(function (View $view, $category, $slug) {
    $category = Str::slug($category);
    $slug = Str::slug($slug);

    $file = File::glob(resource_path('views/entries') . "/*-{$category}--{$slug}.blade.php")[0] ?? null;
    if (!$file) abort(404);

    $file = convertToFileArray(new SplFileInfo($file));

    return $view->with('file', $file)
        ->with('categoryTitle', Str::title(str_replace('-', ' ', $category)));
}); ?>

<x-layout :title="$file['title']">
    <x-header>
        <a href="/entries/{{ $category }}">{{ $categoryTitle }}</a>
    </x-header>

    <section>
        @if ($category === 'weekly')
            <x-weekly-notice/>
        @elseif ($category === 'reflection')
            <x-reflection-notice/>
        @endif

        @include($file['filePath'])
    </section>

    <x-slot name="footer">
        <p class="text-sm">This is published on {{ $file['date']->format('D M d, Y') }}</p>
    </x-slot>
</x-layout>
