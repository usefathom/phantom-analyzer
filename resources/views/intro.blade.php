@extends('template')

@section('content')
<p id="line1" class="hidden">On the internet you are never truly alone.</p>
<p id="line2" class="hidden">Something is always lurking in the shadows.</p>
<p id="line3" class="hidden">You can't see it, but it's there… </p>
<p id="line4" class="hidden">…following you wherever you go online.</p>
<p><a id="line5" class="hidden" href="{{ url('proceed') }}">[Continue]</a></p>
<p id="cursor-line" class="visible">% <span class="typed-cursor">&#9608;</span></p>
@endsection

@section('scripts')
    <script src="{{ asset('js/typed.js') }}"></script>
        <script>
        var timeInit = 1000;     // initial wait before typing first line
        var timeGap = 1200;      // wait time between each line
        var timeChar = 30;       // time until next letter

        var cursorChar = '&#9608;';

        var originId = ['line1', 'line2','line3', 'line4', 'line5'];
        var originText = new Array();
        for (var i = 0; i < originId.length; i++) {
            originText.push(document.getElementById(originId[i]).innerHTML);
        }

        var cursorLine = document.getElementById('cursor-line');

        var currentTimeout;
        var showCursor;

        var typeWriter = function(index) {
            var loc = document.getElementById(originId[index]);
            var fullText = originText[index];
            var letterCount = 0;

            var typeLetter = function() {
                currentTimeout = setTimeout(function() {
                    loc.className = 'visible';
                    letterCount += 1;
                    var showText = fullText.substring(0, letterCount);

                    // stops the function from self-calling when all letters are typed
                    if (letterCount === fullText.length) {
                        loc.innerHTML = '% ' + showText;
                    } else {
                        loc.innerHTML = '% ' + showText + '<span class="typed-cursor">' + cursorChar + '</span>';
                        typeLetter();
                    }
                }, timeChar);
            };

            typeLetter();

            var totalTime = fullText.length * timeChar + timeChar;
            showCursor = setTimeout(function() {
                // document.getElementById('cursor-line').className = 'visible';
            }, totalTime);
        };

        var delayTime = [timeInit];
        var cumulativeDelayTime = [timeInit];
        for (var i = 0; i < originId.length; i++) {
            var elapsedTimeLine = originText[i].length * timeChar + timeGap + timeChar * 2;
            delayTime.push(elapsedTimeLine);
            var sum = 0;
            for (var j = 0; j < delayTime.length; j++) {
                sum += delayTime[j];
            };
            cumulativeDelayTime.push(sum);
        };

        var typeLineTimeout = new Array();
        for (var i = 0; i < originId.length; i++) {
            typeLineTimeout[i] = setTimeout((function(index) {
                return function() {
                    cursorLine.className = 'hidden';
                    typeWriter(index);
                }
            })(i), cumulativeDelayTime[i]);

        };

        var skip = function() {
            clearTimeout(currentTimeout);
            clearTimeout(showCursor);
            for (var i = 0; i < typeLineTimeout.length; i++) {
                clearTimeout(typeLineTimeout[i]);
            };
        };

        var rewriteText = function(element, index, array) {
            var loc = document.getElementById(element);
            loc.innerHTML = '% ' + originText[index];
            loc.className = 'visible';
        };

        window.onkeydown = function(key){
            if (key.which === 13 || key.which === 32) {
                skip();
                originId.forEach(rewriteText);
                document.getElementById('cursor-line').className = 'visible';
            }
        };
        </script>
@endsection
