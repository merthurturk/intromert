<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;

final class CategoryDto
{
    public function __construct(
        public readonly string $title,
        public readonly Carbon $latestEntryDate,
        public readonly string $urlPath)
    {
    }

    public function slug(): string
    {
        return Str::slug($this->title);
    }

    public static function fromSplFileInfo(\SplFileInfo $fileInfo): CategoryDto
    {
        $parts = explode('--', $fileInfo->getFilename());
        $timestamp = (int)Str::before($parts[0], '-');
        $category = Str::after($parts[0], '-');

        return new static(
            title: Str::title(str_replace('-', ' ', $category)),
            latestEntryDate: \Carbon\Carbon::createFromTimestamp($timestamp),
            urlPath: "/entries/{$category}"
        );
    }
}
