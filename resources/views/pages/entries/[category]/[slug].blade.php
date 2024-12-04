<?php

use Illuminate\Support\Str;
use Illuminate\View\View;
use function Laravel\Folio\render;

render(function (View $view, $category, $slug) {
    $slug = Str::slug($slug);

    // todo: optimize/cache directory traversal for category retrieval
    /** @var ?\App\CategoryDto $category */
    $category = \App\getCategories()->filter(fn (\App\CategoryDto $c) => $c->slug() === $category)->first();
    if (!$category) abort(404);
    // todo: optimize/cache directory traversal for entry retrieval
    $entries = \App\getEntries($category->slug());
    /** @var ?\App\EntryDto $entry */
    $entry = $entries->filter(fn(\App\EntryDto $e) => $e->slug() === $slug)->first();
    if (!$entry) abort(404);

    return $view->with('entry', $entry)
        ->with('category', $category);
}); ?>

<x-layout :title="$entry->title">
    <x-header>
        <a href="/entries/{{ $category->slug() }}">{{ $category->title }}</a>
    </x-header>

    <section>
        @if ($category->slug() === 'weekly')
            <x-weekly-notice/>
        @elseif ($category->slug() === 'reflection')
            <x-reflection-notice/>
        @elseif ($category->slug() === 'books')
            <x-books-notice/>
        @endif

        <div class="h-5"></div>

        @include($entry->filePath)
    </section>

    <div class="mt-5">
        <p class="text-sm italic">This is published on {{ $entry->publishDate->format('D M d, Y') }} under
            <a href="/entries/{{ $category->slug() }}">{{ $category->title }}</a> category.</p>
    </div>

    <div class="h-5"></div>
    <x-subscribe-to-newsletter/>
</x-layout>
