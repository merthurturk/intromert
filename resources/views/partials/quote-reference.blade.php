<div>
    <x-blockquote :author="$quote['author']" :href="$quote['href']">
        {{ $quote['content'] }}
    </x-blockquote>
    <p class="text-sm opacity-75">Referenced on:
        <a href="{{ $quote['entry']['url'] }}">{{ $quote['entry']['title'] }}</a></p>
</div>
