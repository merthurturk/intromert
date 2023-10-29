<?php

use Illuminate\View\View;
use function Laravel\Folio\render;

render(fn(View $view) => $view->with('quotes', \Illuminate\Support\Facades\Cache::get('quotes', [])));
?>

<x-layout>
    <x-header>
        <div class="text-base font-medium">Browsing all quotes from all entries. <a href="/quotes/random">See a random one</a>
        </div>
    </x-header>

    <section>
        @foreach ($quotes as $quote)
            <x-blockquote :author="$quote['author']" :href="$quote['href']">
                {{ $quote['content'] }}
            </x-blockquote>
        @endforeach
    </section>
</x-layout>
