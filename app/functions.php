<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;

function getEntries(string $category = null): Collection
{
    $entriesPath = resource_path('views/entries');

    if ($category) {
        $files = collect(File::glob($entriesPath . "/*-{$category}--*.blade.php"))
            ->map(fn (string $filePath) => new SplFileInfo($filePath))
            ->all();
    } else {
        $files = File::files($entriesPath);
    }

    $entries = collect([]);

    foreach ($files as $eachFile) {
        $entries->push(convertToFileArray($eachFile));
    }

    return $entries->sortByDesc('timestamp');
}

function getCategories(): Collection
{
    $files = File::files(resource_path('views/entries'));
    $categories = collect([]);

    foreach ($files as $eachFile) {
        $categories->push(convertToCategoryArray($eachFile));
    }

    return $categories->sortByDesc('timestamp')->unique('urlPath');
}

function convertToCategoryArray(SplFileInfo $fileInfo): array
{
    $parts = explode('--', $fileInfo->getFilename());
    $timestamp = (int)Str::before($parts[0], '-');
    $category = Str::after($parts[0], '-');

    return [
        'title' => Str::title(str_replace('-', ' ', $category)),
        'date' => \Carbon\Carbon::createFromTimestamp($timestamp),
        'timestamp' => $timestamp,
        'urlPath' => "/entries/{$category}",
    ];
}

function convertToFileArray(SplFileInfo $fileInfo): array
{
    $parts = explode('--', $fileInfo->getFilename());
    $timestamp = (int)Str::before($parts[0], '-');
    $category = Str::after($parts[0], '-');

    $file = Str::before($parts[1], '.');
    $title = Str::ucfirst(str_replace('-', ' ', $file));

    $fileName = Str::before($fileInfo->getBasename(), '.');

    return [
        'title' => $title,
        'category' => Str::title(str_replace('-', ' ', $category)),
        'date' => \Carbon\Carbon::createFromTimestamp($timestamp),
        'timestamp' => $timestamp,
        'urlPath' => "/entries/{$category}/{$file}",
        'filePath' => "/entries/{$fileName}",
        'file' => Str::before($fileInfo->getBasename(), '.')
    ];
}
