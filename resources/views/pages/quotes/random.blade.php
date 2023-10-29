<?php

use Illuminate\View\View;
use function Laravel\Folio\render;

$quotes = \Illuminate\Support\Facades\Cache::get('quotes', []);

render(fn(View $view) => $view->with('quote', $quotes[array_rand($quotes)]));
?>

<x-layout>
    <x-header>
        <div class="text-base font-medium">Random quote. <a href="/quotes">See all quotes</a>
        </div>
    </x-header>

    <section>
        <x-blockquote :author="$quote['author']" :href="$quote['href']">
            {{ $quote['content'] }}
        </x-blockquote>
    </section>
</x-layout>
