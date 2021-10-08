<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\Process\Process;

class ScanWebsite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;
    protected $host;

    // The spy pixel list (trackers.txt) is seldom updated
    // If you wish to update it, you should change this
    // and then run phantom:cache_spy_pixels
    const VERSION = 0.2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $host)
    {
        $this->url = $url;
        $this->host = $host;
    }

    public static function hostCacheKey($host)
    {
        return 'host:' . self::VERSION . ':' . $host;
    }

    public static function trackerCacheKey($tracker)
    {
        return 'tracker:' . self::VERSION . ':' . $tracker;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $run = Browsershot::url($this->url)->setBinPath(app_path('Services/Browsershot/browser-local.js'))
                        ->userAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36')
                        ->waitUntilNetworkIdle();

        // Extra pieces required for Laravel Vapor
        if (! App::environment(['local'])) {
            $run->setNodeBinary('/opt/bin/node')
                ->setNodeModulePath('/opt/nodejs/node_modules')
                ->setBinPath(app_path('Services/Browsershot/browser-vapor.js'));
        }

        // This is where the magic starts
        $urls = collect($run->triggeredRequests())->pluck('url');

        $usesFathom = false;

        // Do they have Fathom Analytics installed?
        $urls->filter(function($url) {
            return strpos($url, 'script.js') !== false;
        })->each(function($url) use (&$usesFathom) {
            try {
                $data = @file_get_contents($url);
            } catch (\Exception $e) {
                $data = 'nope';
            }

            if (substr($data, 0, 13) == 'window.fathom') {
                $usesFathom = true;
            }
        });

        if (is_null($urls) || count($urls) == 0) {
            $spyPixels = collect([]);
        } else {
            $keys = $urls->map(function($url) {
                return parse_url($url);
            })->filter(function($url) {
                return (array_key_exists('host', $url));
            })
            ->map(function($url) use (&$usesFathom) {
                $host = $url['host'];

                // In place to support old Fathom files
                if ($host == 'cdn.usefathom.com') {
                    $usesFathom = true;
                }

                if (substr($host, 0, 4) == 'www.') {
                    $host = substr($url['host'], 4);
                }

                return self::trackerCacheKey($host);
            })->unique()->values()->toArray();

            $spyPixels = collect(Cache::many($keys))->filter(function($item) {
                return !empty($item);
            });
        }

        Cache::put(self::hostCacheKey($this->host), (object) [
            'spyPixels' => $spyPixels,
            'date' => now(),
            'usesFathom' => $usesFathom
        ], 300);
    }
}
