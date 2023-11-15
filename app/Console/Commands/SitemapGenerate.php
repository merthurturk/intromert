<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use function App\getCategories;
use function App\getEntries;

class SitemapGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sitemap for the whole website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $process = new Process(['git', 'log', '-1', '--format=%cd', '--date=short']);
        $process->run();

        $latestCommitDate = Carbon::createFromFormat('Y-m-d', trim($process->getOutput()));

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        $xml .= $this->getUrlTagString(config('app.url'), $latestCommitDate);
        $xml .= $this->getUrlTagString(config('app.url') . '/quotes', $latestCommitDate);

        $categories = getCategories();
        foreach ($categories as $eachCategory) {
            $xml .= $this->getUrlTagString(config('app.url') . $eachCategory->urlPath, $eachCategory->latestEntryDate);
        }

        $entries = getEntries();
        foreach ($entries as $eachEntry) {
            $xml .= $this->getUrlTagString(config('app.url') . $eachEntry->urlPath, $eachEntry->publishDate);
        }

        $xml .= '</urlset>';

        file_put_contents(public_path('sitemap.xml'), $xml);

        $this->line('The sitemap.xml file has been successfully saved to the public/sitemap.xml directory.');
    }

    protected function getUrlTagString(string $location, Carbon $lastModifiedAt, string $changeFrequency = 'daily', string $priority = '0.8'): string
    {
        $lastModifiedAtFormatted = $lastModifiedAt->format('Y-m-d');
        return "\t" . '<url>' . PHP_EOL
            . "\t\t<loc>{$location}</loc>" . PHP_EOL
            . "\t\t<lastmod>{$lastModifiedAtFormatted}</lastmod>" . PHP_EOL
            . "\t\t<changefreq>{$changeFrequency}</changefreq>" . PHP_EOL
            . "\t\t<priority>{$priority}</priority>" . PHP_EOL
            . "\t" . '</url>' . PHP_EOL;
    }
}
