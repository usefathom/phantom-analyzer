<!DOCTYPE html>
<html lang="en">
    <head>
        <title>@yield('title', 'Phantom Analyzer')</title>

        <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
        <link rel="icon" type="image/svg+xml" sizes="any" href="{{ asset('images/favicon.svg') }}">
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="preload" as="font" href="{{ asset('fonts/JetBrainsVar.woff2') }}" type="font/woff2" crossorigin="anonymous">

        <link rel="stylesheet" href="{{ asset('css/phantom.min.css') }}">
        <meta name="description" content="A website scanner to see what invisible creepers are lurking in the shadows & collecting info about you." />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Phantom Analyzer" />
        <meta property="og:description" content="A website scanner to see what invisible creepers are lurking in the shadows & collecting info about you." />
        <meta property="og:url" content="{{ url('/' )}}" />
        <meta property="og:site_name" content="Phantom Analyzer" />
        <meta property="og:locale" content="en" />
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@usefathom" />

        @hasSection('twitter_share')
            @yield('twitter_share')
        @else
            <meta name="twitter:title" content="Phantom Analyzer" />
            <meta name="twitter:description" content="A website scanner to see what invisible creepers are lurking in the shadows & collecting info about you." />
            <meta property="og:image:width" content="1200" />
            <meta property="og:image:height" content="600" />
            <meta name="twitter:image:alt" content="" />
            <meta property="og:image:alt" content="" />
        @endif

    </head>

    <!-- REMOVE BEFORE GOING LIVE -->
    <!-- NOTE TO SELF: Here are credentials for production services. -->
    <!-- pw: blueocean22 -->
    <!-- https://usephantom.com/credentials/A5F8V2DkAT4D1APRhFmS -->
    <!-- REMOVE BEFORE GOING LIVE -->

    <body class="{{ request()->path() == '/' ? 'fade' : null }}">
        <div class="rapper">
            @yield('content')
        </div><!--rapper-->

        <!-- Fathom - beautiful, simple website analytics -->
        <script src="https://cdn.usefathom.com/script.js" data-site="YOUR-SITE-ID" defer></script>
        <!-- / Fathom -->
    </body>

    @yield('scripts')

    <script>
        function spawnABat() {
            /*! Halloween bats - Luca Munich - https://devunit.org */
            /* Luca - you rock <3 */
            ;(function () {
            var r=Math.random,n=0,d=document,w=window,
                i=d.createElement('img'),
                z=d.createElement('div'),
                zs=z.style,
                a=w.innerWidth*r(),b=w.innerHeight*r();
            zs.position="fixed";
            zs.left=0;
            zs.top=0;
            zs.opacity=0;
            z.appendChild(i);
            i.src='data:image/gif;base64,R0lGODlhMAAwAJECAAAAAEJCQv///////yH/C05FVFNDQVBFMi4wAwEAAAAh+QQJAQACACwAAAAAMAAwAAACdpSPqcvtD6NcYNpbr4Z5ewV0UvhRohOe5UE+6cq0carCgpzQuM3ut16zvRBAH+/XKQ6PvaQyCFs+mbnWlEq0FrGi15XZJSmxP8OTRj4DyWY1lKdmV8fyLL3eXOPn6D3f6BcoOEhYaHiImKi4yNjo+AgZKTl5WAAAIfkECQEAAgAsAAAAADAAMAAAAnyUj6nL7Q+jdCDWicF9G1vdeWICao05ciUVpkrZIqjLwCdI16s+5wfck+F8JOBiR/zZZAJk0mAsDp/KIHRKvVqb2KxTu/Vdvt/nGFs2V5Bpta3tBcKp8m5WWL/z5PpbtH/0B/iyNGh4iJiouMjY6PgIGSk5SVlpeYmZqVkAACH5BAkBAAIALAAAAAAwADAAAAJhlI+py+0Po5y02ouz3rz7D4biSJbmiabq6gCs4B5AvM7GTKv4buby7vsAbT9gZ4h0JYmZpXO4YEKeVCk0QkVUlw+uYovE8ibgaVBSLm1Pa3W194rL5/S6/Y7P6/f8vp9SAAAh+QQJAQACACwAAAAAMAAwAAACZZSPqcvtD6OctNqLs968+w+G4kiW5omm6ooALeCusAHHclyzQs3rOz9jAXuqIRFlPJ6SQWRSaIQOpUBqtfjEZpfMJqmrHIFtpbGze2ZywWu0aUwWEbfiZvQdD4sXuWUj7gPos1EAACH5BAkBAAIALAAAAAAwADAAAAJrlI+py+0Po5y02ouz3rz7D4ZiCIxUaU4Amjrr+rDg+7ojXTdyh+e7kPP0egjabGg0EIVImHLJa6KaUam1aqVynNNsUvPTQjO/J84cFA3RzlaJO2495TF63Y7P6/f8vv8PGCg4SFhoeIg4UQAAIfkEBQEAAgAsAAAAADAAMAAAAnaUj6nL7Q+jXGDaW6+GeXsFdFL4UaITnuVBPunKtHGqwoKc0LjN7rdes70QQB/v1ykOj72kMghbPpm51pRKtBaxoteV2SUpsT/Dk0Y+A8lmNZSnZlfH8iy93lzj5+g93+gXKDhIWGh4iJiouMjY6PgIGSk5eVgAADs=';
            d.body.appendChild(z);
            function R(o,m){return Math.max(Math.min(o+(r()-.5)*400,m-50),50)}
            function A(){
                var x=R(a,w.innerWidth),y=R(b,w.innerHeight),
                    d=5*Math.sqrt((a-x)*(a-x)+(b-y)*(b-y));
                zs.opacity=n;n=1;
                zs.transition=zs.webkitTransition=d/1e3+'s linear';
                zs.transform=zs.webkitTransform='translate('+x+'px,'+y+'px)';
                i.style.transform=i.style.webkitTransform=(a>x)?'':'scaleX(-1)';
                a=x;b=y;
                setTimeout(A,d);
            };setTimeout(A,r()*3e3);
            })();
        }

        spawnABat();
        spawnABat();
    </script>
</html>
