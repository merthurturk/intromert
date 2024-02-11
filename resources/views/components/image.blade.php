@props(['src'])
<figure>
    <img src="{{ $src }}" class="mx-auto"/>
    <figcaption class="text-center">{{ $slot }}</figcaption>
</figure>
