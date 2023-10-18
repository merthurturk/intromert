@props(['src'])
<figure>
    <img src="{{ $src }}"/>
    <figcaption class="text-center">{{ $slot }}</figcaption>
</figure>
