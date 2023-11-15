<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;

final class EntryDto
{
    public function __construct(
        public readonly string $title,
        public readonly string $category,
        public readonly Carbon $publishDate,
        public readonly string $urlPath,
        public readonly string $filePath,
        public readonly string $fileBasename,
    )
    {
    }

    public function slug(): string
    {
        return Str::slug($this->title);
    }

    public static function fromSplFileInfo(\SplFileInfo $fileInfo): EntryDto
    {
        $parts = explode('--', $fileInfo->getFilename());
        $timestamp = (int)Str::before($parts[0], '-');
        $category = Str::after($parts[0], '-');

        $file = Str::before($parts[1], '.');
        $title = Str::ucfirst(str_replace('-', ' ', $file));

        $fileName = Str::before($fileInfo->getBasename(), '.');

        return new static(
            title: $title,
            category: Str::title(str_replace('-', ' ', $category)),
            publishDate: \Carbon\Carbon::createFromTimestamp($timestamp),
            urlPath: "/entries/{$category}/{$file}",
            filePath: "/entries/{$fileName}",
            fileBasename: Str::before($fileInfo->getBasename(), '.')
        );
    }
}
