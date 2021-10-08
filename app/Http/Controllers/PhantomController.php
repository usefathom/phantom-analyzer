<?php

namespace App\Http\Controllers;

use App\Jobs\ScanWebsite;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Spatie\Browsershot\Browsershot;

class PhantomController extends Controller
{
    public function failed()
    {
        return redirect('/')->with('errors', new MessageBag(['There was an error scanning this website']));
    }

    private static function facts()
    {
        return collect([
            'Fun fact: Halloween started in Ireland (dating back over 2,000 years).',
            'Did you know: Jack O’Lanterns were originally carved out of turnips, potatoes and beets.',
            'Fun fact: Pumpkins are a fruit, not a vegetable.',
            'Did you know: In Texas Chainsaw Massacre… only a single person was killed by a chainsaw.',
            'Fun fact: New Englanders call the night before halloween Cabbage Night.',
            'Did you know: It’s illegal to dress up like a nun or priest in Alabama ($500 fine or up to a year in jail).',
            'Fun fact: “Samhainophobia” is the fear of Halloween.',
            'Did you know: Trick or treating has existed since medieval times when young folks dressed up and asked for money or food in exchange for songs or poems.',
            'Fun fact: In America consumers spend over $9 billion in 2019 on Halloween.',
            'Did you know: In WWII trick or treating was halted due to sugar rationing because of the war.',
            'Fun fact: This Halloween (2020) is the first one in 19 years to have a full moon.',
            'Did you know: The Michael Myers mask is a William Shatner mask painted white with the eyes cut out.',
            'Fun fact: Bathurst, Canada has banned anyone over the age of 16 from trick or treating, with a $200 fine.'
        ]);
    }

    public function main(Request $request, $host = null)
    {
        if (empty($host)) {
            // Once they've seen the intro, we don't show it again (for session duration)
            if (! empty($request->session()->get('skip_intro'))) {
                return view('main')->with('randomFact', self::facts()->random());
            } else {
                return view('intro');
            }
        }

        return $this->results($host);
    }

    public function proceed(Request $request)
    {
        // Don't show the intro again
        $request->session()->put('skip_intro', true);

        return redirect('/');
    }

    public function ping($host)
    {
        // Do we have a result for the host being scanned?
        if (empty(Cache::get(ScanWebsite::hostCacheKey($host)))) {
            return response('no');
        }

        return response('Success');
    }

    protected function results($host)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $host)) {
            $url = 'https://' . $host;
        }

        $validator = Validator::make(['url' => $url], [
            'url' => ['required', 'string', 'active_url'],
        ]);

        try {
            $validator->validate();
        } catch (\Exception $e) {
            return redirect('/')->with('errors', new MessageBag(['Please enter a valid URL']));
        }

        // Do we have an entry for the hostname to display in the results?
        $result = Cache::get(ScanWebsite::hostCacheKey($host));

        // Nope? Probably because it's a first-time lookup, or the cache has expired
        if (empty($result)) {
            $urlParts = parse_url($url);

            // So let's dispatch the puppeteer job to scan that baby
            retry(10, function() use ($url, $urlParts) {
                ScanWebsite::dispatch($url, Arr::get($urlParts, 'host'));
            });

            return view('main', [
                'loading' => true,
                'randomFact' => self::facts()->random(),
                'host' => $host,
                'title' => 'Test'
            ]);
        } else {
            return view('results', [
                'host' => $host,
                'date' => $result->date,
                'totalTrackers' => $result->spyPixels->count(),
                'spyPixels' => $result->spyPixels,
                'usesFathom' => $result->usesFathom,
                'googleTracking' => $result->spyPixels->filter(function($value) {
                    return strpos($value, 'google') !== false;
                })->count() > 0,
                'facebookTracking' => $result->spyPixels->filter(function($value) {
                    return strpos($value, 'facebook') !== false;
                })->count() > 0,
            ]);
        }
    }
}

