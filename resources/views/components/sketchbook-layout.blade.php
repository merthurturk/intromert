@props(['slug'])

<?php
use Illuminate\Support\Facades\File;
$sketchbookImages = collect(File::files(public_path('assets/images/sketchbooks/' . $slug)))
    ->map(fn($file) => '/assets/images/sketchbooks/' . $slug . '/' . $file->getFilename());
?>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">

    <div class="col-span-1 relative">
        <div class="md:sticky top-[20px]">
            {{ $slot }}
        </div>
    </div>

    <div class="lg:col-span-2 grid grid-cols-2 gap-1">
        @foreach ($sketchbookImages as $image)
            <img src="{{ $image }}" class="aspect-auto w-full m-0"/>
        @endforeach
    </div>

</div>
