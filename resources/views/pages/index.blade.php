<?php

use Illuminate\View\View;
use function App\getEntries;
use function Laravel\Folio\render;

render(fn (View $view) => $view->with('entries', getEntries()));
?>

<x-layout>
    <x-about/>

    <section>
        <h3>Projects &amp; Resources</h3>
        <ul>
            <li><a href="https://upcoach.com">Upcoach</a> &mdash; A fully integrated suite of coaching tools, designed to empower coaches and their clients. I co-founded Upcoach, built it from the ground up, assembled an incredible team, and we’re still rocking.</li>
            <li><a href="https://octeth.com">Octeth</a> &mdash; A marketing super-engine built for serious marketers. As a co-founder, I’ve developed innovative, self-hosted software solutions and continue to push the boundaries of what’s possible.</li>
            <li><a href="https://sumbox.io">SumBox</a> &mdash; A tool to rediscover the joy of newsletters. As the founder and developer, I’m hands-on with every aspect of SumBox, from coding to design to marketing.</li>
            <li><a href="https://wridea.com">Wridea</a> &mdash; A tool to help individuals and teams brainstorm, organize, and collaborate on ideas. I created Wridea originally to make managing thoughts and creative processes simple and effective. In its current shape, it’s pivoted from the original idea but will come back to its roots soon.</li>
            <li>Explore <a href="/quotes">Quotes</a> I love or snag a <a href="/quotes/random">Random Quote</a> I've referenced!</li>
        </ul>
    </section>

    <x-subscribe-to-newsletter/>

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
</x-layout>
