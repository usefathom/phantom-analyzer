@extends('template')

@section('content')
<img src="{{ asset('images/phantom-analyzer.png') }}" class="Phantom Analyzer">

<h2>A simple, real-time website scanner to see what invisible creepers are lurking in the shadows and collecting information about you. Created by <a href="https://usefathom.com">Fathom Analytics</a>.</h2>

@if ($errors->any())
    <div style="margin: 3rem 0 0rem 0;color: #dc3333;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (isset($loading))
@section('title', 'Scanning ' . $host . ' - Phantom Analyzer')

@include('loading')
@else
<form method="POST" id="url-form" onclick="javascript:document.getElementById('url').focus();">
    @csrf

    <input type="text" placeholder="Enter a URL" id="url" name="url" autofocus required>
    <button type="submit">Scan -></button>
</form>
@endif

<div class="grid">
    <div class="col">
        <h3>What is Phantom Analyzer?</h3>
        <small>It was created by Jack and Paul from <a href="https://usefathom.com">Fathom Analytics</a> (apparently some folks hear "phantom" when we say "fathom"). Fathom doesn’t do anything spooky with website visitor data and is fully GDPR, PECR and CCPA compliant. Our aim is to make the internet a less scary place, giving less power to ghoulishly big tech companies.</small>
    </div>
    <div>
        <img src="{{ asset('images/ghost-cat.svg') }}" alt="Fathom Analytics ghost cat" class="floating">
    </div>
</div><!--grid-->
@endsection

@if (isset($loading))
    @section('scripts')
    <script>
    var totalReloads =  0;

    setInterval(function(){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            totalReloads++;

            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText == 'Success') {
                    window.location.reload();
                }
            }
        };
        xhttp.open("GET", "/ping/{{$host}}", true);
        xhttp.send();

        if (totalReloads >= 61) {
            window.location = '/failed';
        }
    }, 3000);
    </script>
    @endsection
@else
    @section('scripts')
    <script>
    document.getElementById('url-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const withHttp = url => !/^https?:\/\//i.test(url) ? `https://${url}` : url;

        var a = document.createElement('a');
        a.href = withHttp(document.getElementById('url').value);

        window.location = '/' + a.hostname;
    });
    </script>
    @endsection

@endif
