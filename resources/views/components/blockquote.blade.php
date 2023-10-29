@props(['author', 'href'])
<blockquote>
    <p>{{ $slot }}</p>
    <div class="-mt-5 opacity-50">
        &mdash;
        @if(!empty($href))
            <a href="{{ $href }}" target="_blank">{{ $author }}</a>
        @else
            {{ $author }}
        @endif
    </div>
</blockquote>
