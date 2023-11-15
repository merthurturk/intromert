<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use SplFileInfo;

/**
 * Returns a collection of entries. If a category is given, returns only
 * entries under that category.
 * @param string|null $category
 * @return Collection<EntryDto>
 */
function getEntries(string $category = null): Collection
{
    $entriesPath = resource_path('views/entries');

    if ($category) {
        $files = collect(File::glob($entriesPath . "/*-{$category}--*.blade.php"))
            ->map(fn(string $filePath) => new SplFileInfo($filePath))
            ->all();
    } else {
        $files = File::files($entriesPath);
    }

    $entries = collect([]);

    foreach ($files as $eachFile) {
        $entries->push(EntryDto::fromSplFileInfo($eachFile));
    }

    return $entries->sortByDesc(fn(EntryDto $entry) => $entry->publishDate->timestamp);
}

/**
 * Returns a collection of categories.
 * @return Collection<CategoryDto>
 */
function getCategories(): Collection
{
    $files = File::files(resource_path('views/entries'));
    $categories = collect([]);

    foreach ($files as $eachFile) {
        $categories->push(CategoryDto::fromSplFileInfo($eachFile));
    }

    return $categories->sortByDesc('timestamp')->unique('urlPath');
}
