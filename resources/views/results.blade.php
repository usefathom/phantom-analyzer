@extends('template')

@section('title', 'Results for ' . $host . ' - Phantom Analyzer')

@section('twitter_share')

<meta name="twitter:title" content="Results for {{ $host }} - Phantom Analyzer" />
<meta name="twitter:description" content="Phantom Analyzer has scanned {{ $host }} for tracking pixels. Here’s what we found." />
<meta property="og:image:width" content="1200" />
<meta property="og:image:height" content="600" />
<meta name="twitter:image:alt" content="" />
<meta property="og:image:alt" content="" />

@endsection

@section('content')
<a href="{{ url('/') }}"><img src="{{ asset('images/phantom-analyzer.png') }}" class="Phantom Analyzer"></a>
<h2>A simple, real-time website scanner to see what invisible creepers are lurking in the shadows and collecting information about you. Created by <a href="https://usefathom.com">Fathom Analytics</a>.</h2>

<h3 class="fade">We visited <a href="https://{{ $host }}" target="blank" rel="nofollow">{{ $host }}</a> on {{ $date->format('F j, Y')}} at {{ $date->format('g:ia') }} UTC and found:</h3>


<div class="results fade">
    @if (isset($usesFathom) && $usesFathom == true)
    <div class="result fathom">
        <div class="number">😻</div>
        <div>You use Fathom Analytics and we love you for it</div>
    </div>
    @endif

    @if ($totalTrackers == 0)
    <div class="result zero">
        <div class="number">🧛‍♀️</div>
        <div>Fang-tastic! {{ $host }} has ZERO spooky trackers present</div>
    </div>
    @else

    <div class="result">
        <div class="number">{{ $totalTrackers }}</div>
        <div>Ghastly tracking {{ Str::plural('pixel', $totalTrackers) }} @if ($totalTrackers == 1) was @else were @endif found (<a href="#details" class="toggle" onclick="javascript:toggleDetails(); return false;">details</a>)</div>
    </div>

    <div class="details fade" id="details" style="display: none;">
        <ol>
            @foreach ($spyPixels as $pixel)
                <li>{{ $pixel }}</li>
            @endforeach
        </ol>
    </div>

    @if ($googleTracking)
    <div class="result">
        <div class="number">👻</div>
        <div>Google is tracking you from the shadows on this website</div>
    </div>
    @endif

    @if ($facebookTracking)
    <div class="result">
        <div class="number">👀</div>
        <div>Facebook is watching and eerily tracking you on this website</div>
    </div>
    @endif

    @endif

    <a href="/" style="margin-top: 5px; display:inline-block;">Scan another website</a>

</div><!--results-->

@if ($totalTrackers == 0)
<p class="share"><a target="_blank" href="http://twitter.com/share?text=Woo hoo! I just used Phantom Analyzer to scan a website and it found no tracking pixels&url={{ url()->current() }}&hashtags=phantomanalyzer
">Share these results on Twitter -></a></p>
@else
<p class="share"><a target="_blank" href="http://twitter.com/share?text=Ruh Roh. I just used Phantom Analyzer to scan a website and it found {{ $totalTrackers }} ghostly tracking pixels&url={{ url()->current() }}&hashtags=phantomanalyzer
">Share these results on Twitter -></a></p>
@endif

<h3>Every share is a chance to win</h3>
<small>Share your results on Twitter for a chance to win 2 full years of Fathom’s $14/m plan for free (for new or existing customers) and a limited edition ghostly cat hoodie. This contest closes at midnight on Oct 31, 2020.</small>

<div class="grid">
    <div class="col">
        <h3>What is Phantom Analyzer?</h3>
        <small>It was created by Jack and Paul from <a href="https://usefathom.com">Fathom Analytics</a> (apparently some folks hear "phantom" when we say "fathom"). Fathom doesn’t do anything spooky with website visitor data and is fully GDPR, PECR and CCPA compliant. Our aim is to make the internet a less scary place, giving less power to ghoulishly big tech companies.</small>
    </div>
    <div><img src="{{ asset('images/ghost-cat.svg') }}" alt="Fathom Analytics ghost cat" class="floating"></div>
    </div><!--grid-->

    <span class="wrong">Results seem wrong? <a href="mailto:support@usefathom.com">Let us know</a>!</span>

    @endsection


@section('scripts')
<script>
    function toggleDetails() {
        var details = document.getElementById("details");
        if (details.style.display == "none") {
            details.style.display = "block";
        } else {
            details.style.display = "none";
        }
    }
</script>
@endsection
