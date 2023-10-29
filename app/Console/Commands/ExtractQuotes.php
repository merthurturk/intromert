<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use function App\getCategories;
use function App\getEntries;

class ExtractQuotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'extract:quotes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract quotes from entries';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bladeFiles = File::allFiles(resource_path('views/entries'));
        $blockquotes = [];

        foreach ($bladeFiles as $file) {
            $content = File::get($file->getPathname());

            // Match all <x-blockquote> components
            preg_match_all('/<x-blockquote\s+author="([^"]+)"(?:\s+href="([^"]+)")?>([\s\S]*?)<\/x-blockquote>/', $content, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                $blockquotes[] = [
                    'author' => $match[1] ?? null,
                    'href' => $match[2] ?? null,
                    'content' => trim($match[3])
                ];
            }

            Cache::put('quotes', $blockquotes);
        }

        $this->line('All quotes from all entries (' . count($blockquotes) . ') cached successfully.');
    }
}
