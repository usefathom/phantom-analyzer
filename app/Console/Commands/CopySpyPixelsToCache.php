<?php

namespace App\Console\Commands;

use App\Jobs\ScanWebsite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CopySpyPixelsToCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'phantom:cache_spy_pixels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Put all the tracking pixels into cache';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $trackers = array_filter(explode("\n", Storage::disk('resources')->get('trackers.txt')));

        foreach ($trackers as $tracker) {
            retry(10, function() use ($tracker) {
                Cache::rememberForever(ScanWebsite::trackerCacheKey($tracker), function() use ($tracker) {
                    return $tracker;
                });
            });
        }
    }
}
