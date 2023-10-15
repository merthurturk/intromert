@props(['author'])
<blockquote>
    <p>{{ $slot }}</p>
    <div class="-mt-5 opacity-50">&mdash; {{ $author }}</div>
</blockquote>
