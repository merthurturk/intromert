<?php

use Illuminate\View\View;
use function App\getEntries;
use function Laravel\Folio\render;

render(fn (View $view) => $view->with('entries', getEntries()));
?>

<x-layout>
    <x-about/>

    <section>
        <h3>Latest</h3>
        <ul>
            @foreach ($entries as $eachEntry)
                <li><a href="{{ $eachEntry['urlPath'] }}">{{ $eachEntry['title'] }}</a>
                    <small class="text-zinc-400">&mdash; {{ $eachEntry['date']->format('D M d, Y') }} / {{ $eachEntry['category'] }}</small>
                </li>
            @endforeach
        </ul>
    </section>
</x-layout>
