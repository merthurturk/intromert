@props(['src'])
<figure>
    <img src="{{ $src }}"/>
    <figcaption>{{ $slot }}</figcaption>
</figure>
