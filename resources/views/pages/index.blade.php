<?php

use Illuminate\Support\Facades\File;
use Illuminate\View\View;

use function App\getEntries;
use function Laravel\Folio\render;

render(function (View $view) {
    $entries = getEntries();

    $sketchbooks = $entries
        ->filter(fn($entry) => $entry->category === 'Sketchbooks')
        ->map(function ($entry) {
            // get a random image from sketchbook asset path here
            $thumbnail =
                '/assets/images/sketchbooks/' . $entry->slug() . '/' .
                collect(File::files(public_path('assets/images/sketchbooks/' . $entry->slug())))->random()->getFilename();

            return [
                'urlPath' => $entry->urlPath,
                'thumbnail' => $thumbnail,
                'title' => $entry->title,
            ];
        })->all();

    $view
        ->with('entries', $entries)
        ->with('sketchbooks', array_values($sketchbooks));
});
?>

<x-layout>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
        <div>
            <x-about/>
            <p>Explore <a href="/quotes">Quotes</a> I love or snag a <a href="/quotes/random">Random Quote</a> I've referenced!</p>
            <x-subscribe-to-newsletter/>
        </div>


        <div>
            <section>
                <h3>Projects</h3>
                <ul>
                    <li>
                        <a href="https://upcoach.com">Upcoach</a> &mdash; A fully integrated suite of coaching tools, designed to empower coaches and their clients. (Co-Founder, CTO)
                    </li>
                    <li>
                        <a href="https://octeth.com">Octeth</a> &mdash; A marketing super-engine built for serious marketers. (Co-Founder)
                    </li>
                    <li>
                        <a href="https://sumbox.io">SumBox</a> &mdash; A tool to rediscover the joy of newsletters. (Indie Hacker)
                    </li>
                    <li>
                        <a href="https://wridea.com">Wridea</a> &mdash; A tool to help individuals and teams brainstorm, organize, and collaborate on ideas. (Indie Hacker)
                    </li>
                </ul>
            </section>
            <section>
                <h3>Sketchbooks</h3>
                <div class="grid grid-cols-2 gap-5">
                    @foreach ($sketchbooks as $sketchbook)
                        <a href="{{ $sketchbook['urlPath'] }}" class="flex flex-col gap-1">
                            <img src="{{ $sketchbook['thumbnail'] }}" alt="Sketchbook Thumbnail" class="m-0"/>
                            <span class="leading-6">{{ $sketchbook['title'] }}</span>
                        </a>
                    @endforeach
                </div>
            </section>
        </div>

        <section>
            <h3>Latest</h3>
            <ul>
                @foreach ($entries as $eachEntry)
                    <li><a href="{{ $eachEntry->urlPath }}" class="capitalize">{{ $eachEntry->title }}</a>
                        <small class="text-zinc-400">&mdash; {{ $eachEntry->publishDate->format('D M d, Y') }} / {{ $eachEntry->category }}</small>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>

</x-layout>
