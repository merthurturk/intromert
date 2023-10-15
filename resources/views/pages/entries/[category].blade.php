<?php

use Illuminate\Support\Str;
use Illuminate\View\View;
use function App\getEntries;
use function Laravel\Folio\render;

render(function (View $view, $category) {
    $category = Str::slug($category);

    return $view->with('entries', getEntries($category))
        ->with('categoryTitle', Str::title(str_replace('-', ' ', $category)))
        ->with('categorySlug', $category);
}); ?>

<x-layout>
    <x-header>
        <div class="text-base font-medium">Viewing {{ $categoryTitle }} entries. <a href="/">See all</a></div>
    </x-header>

    <section>
        @if ($categorySlug === 'weekly')
            <x-weekly-notice :show-more-link="false"/>
        @elseif ($categorySlug === 'reflection')
            <x-reflection-notice :show-more-link="false"/>
        @endif

        <ul>
            @foreach ($entries as $eachEntry)
                <li><a href="{{ $eachEntry['urlPath'] }}">{{ $eachEntry['title'] }}</a>
                    <small class="text-zinc-400">&mdash; {{ $eachEntry['date']->format('D M d, Y') }} / {{ $eachEntry['category'] }}</small>
                </li>
            @endforeach
        </ul>
    </section>
</x-layout>
