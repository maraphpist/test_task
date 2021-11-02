<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
<head>
    <!-- Website Design By: www.happyworm.com -->
    <title>Demo (jPlayer 1.2.0) : jPlayer as a flexible audio player</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <link href="/front/skin/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
    <link id="democss" href="/front/css/demo.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="/front/js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="/front/js/jquery.jplayer.min.js"></script>

    <script type="text/javascript">
        <!--
        $(document).ready(function(){

            // Local copy of jQuery selectors, for performance.
            var jpPlayTime = $("#jplayer_play_time");
            var jpTotalTime = $("#jplayer_total_time");

            var audio_url = $("#track_url").attr('href');

            var audioEnded = false;

            $("#jquery_jplayer").jPlayer({
                ready: function () {
                    this.element.jPlayer("setFile", audio_url);
                },
                volume: 50,
                oggSupport: false,
                preload: 'none'
            })
                .jPlayer("onProgressChange", function(loadPercent, playedPercentRelative, playedPercentAbsolute, playedTime, totalTime) {
                    jpPlayTime.text($.jPlayer.convertTime(playedTime));
                    jpTotalTime.text($.jPlayer.convertTime(totalTime));
                    audioEnded = false;
                })
                .jPlayer("onSoundComplete", function() {
                    //this.element.jPlayer("play");
                    //console.log(wordTimes);
                    $('#textcontent a').css('background-color','white');
                    wordIndex = 0;
                    currentWord = 0;
                    audioEnded = true;
                    //clearInterval(timer);
                });

            // end of jPlayer set up

            var bgimage = $("#track_waveform").attr('href');
            var imgOriWidth = 1430, imgOriHeight = 750, imgFinWidth = 1430, imgFinHeight = 750;
            $('#imageedit').val(bgimage);
            $('#timingsedit').val('');
            $('#defaultstate').attr('checked', true);
            $('#oriwidth').val(imgOriWidth);
            $('#finwidth').val(imgFinWidth);
            $('#oriheight').val(imgOriHeight);
            $('#finheight').val(imgFinHeight);




            function getSelText()
            {
                var txt = '';
                if (window.getSelection)
                {
                    txt = window.getSelection();
                }
                else if (document.getSelection)
                {
                    txt = document.getSelection();
                }
                else if (document.selection)
                {
                    txt = document.selection.createRange().text;
                }

                return txt;
            }



            function clean(s)
            {
                return(s.replace('\n', '', 'g')); // Strip out carriage returns
            }



            // put the words in an array
            var textcontent = $('#textcontent');
            $('#textedit').val(textcontent.text());
            var word = textcontent.text().split(" ");
            textcontent.text('');

            $('#textcontent').mouseup(function(e){
                var select = getSelText();
                select = new String(select).split(" ");

                //console.log(select.length);
                //console.dir(select);

                var i = 0;
                var w = 0;
                var startindex = 0, endindex = 0, startfound = false, endfound = false, matches = 0;

                while (w < word.length)
                {
                    //console.log("--"+select[i]+"--");
                    //console.log("--"+clean(word[w])+"--");

                    while (clean(word[w]) ==  select[i])
                    {
                        //console.log('match');

                        if (!startfound)
                        {
                            startfound = true;
                            startindex = w;
                            //console.log("startindex = "+startindex);
                        }
                        else if (i == select.length-1)
                        {
                            endfound = true;
                            endindex = w;
                            //console.log("endindex = "+endindex);

                            selectStart = startindex;
                            selectEnd = endindex;
                            //console.log("SELECTED");
                            //alert('SELECTED');
                            $("#selected").show().fadeOut(3000);

                            return false;
                        }

                        i++;
                        w++;
                    }
                    i = 0;
                    startfound = false;
                    w++;
                }
            });

            var selectStart = null;
            var selectEnd = null;
            var selectPlaying = false;

            function wrapWords(){
                $.each(word, function(index, value) {
                    textcontent.append('<a href="#'+index+'" id="w-'+index+'">'+value+" </a>");
                });
            }

            wrapWords();

            var wordTimes = new Array(word.length);

            $('#textcontent a').live('click', function() {

                selectStart = null;
                selectEnd = null;
                selectPlaying = false;

                var wordNum = $(this).attr('href').replace('#','');

                if ($('#editmode_form input:radio:checked').val() == 'y') {
                    //var playedTime = $('#jquery_jplayer audio').get(0).currentTime;
                    var playedTime = $('#jquery_jplayer').jPlayer("getData", "diag.playedTime");
                    //console.log(wordNum);
                    //rounding to 2 decimal places
                    playedTime = 1000*roundToDp(playedTime,2);
                    wordTimes[wordNum] = playedTime;
                    //console.log($(this).attr('id')+' '+playedTime);
                    //console.log(wordTimes);
                }else{
                    wordIndex = parseInt(wordNum);
                    currentWord = parseInt(wordNum);
                    //console.log("PLAY");
                    //console.log(wordTimes[wordNum]);
                    $("#jquery_jplayer").jPlayer("playHeadTime", wordTimes[wordNum]);

                    highlightWord(wordNum);
                }
                return false;
            });

            var wordIndex = 0;
            $(document).keypress(function(e){
                if(e.which == 32){
                    addTiming();
                }
                // escape key for returning to synch mode
                if(e.which == 0){
                    $('#defaultstate').attr('checked',true);
                    $('#editmode_form input:radio:checked').val('y').trigger('change');
                }
            });

            $('#syncbtn').click(function() {
                addTiming();
            });

            function roundToDp(p,d) {
                return (Math.round(p*Math.pow(10,d))/Math.pow(10,d));
            }

            function addTiming() {
                highlightWord(wordIndex);
                //var playedTime = $('#jquery_jplayer audio').get(0).currentTime;
                var playedTime = $('#jquery_jplayer').jPlayer("getData", "diag.playedTime")
                playedTime = roundToDp(playedTime,2);
                wordTimes[wordIndex] = playedTime;
                $('#timingsedit').val(wordTimes);
                wordIndex++;
            }

            function highlightWord(i) {
                $('#textcontent a').css('background-color','white');
                $('#w-'+i).css('background-color','yellow');
            }

            var timer = null;
            var context;
            var democss = $('#democss').html();
            //alert(democss);

            // Create a new image.
            var img = new Image();

            function checkMode() {
                //console.log('checking mode');
                clearInterval(timer);
                var state = $('#editmode_form input:radio:checked').val();


                if (state == 'y') {
                    if ($('#democss').length == 0)
                    {
                        $('head').append('<link id="democss" href="demo.css" rel="stylesheet" type="text/css" />');
                    }
                    $('#myCanvas').hide();
                    $('#editmode_form').show();
                    $('#syncbtn').fadeIn();
                    $('#synctext').show();
                    $('#playtext').hide();
                    $('#hack').hide();
                    //$('.inputdelay').fadeOut();
                    clearInterval(timer);
                }
                if (state == 'n') {

                    // checks every 10 ms NB for debugging may need to use 100ms as firebug has trouble keeping up
                    timer = setInterval(checkTime, 10);
                    $('#syncbtn').fadeOut();
                    $('#synctext').hide();
                    $('#playtext').show();
                    $('#hack').hide();
                    //$('.inputdelay').fadeIn();
                }
                if (state == 'v') {
                    $('#hack').hide();
                    timer = setInterval(checkTime, 10);
                    $('#editmode_form').hide();


                    $('#democss').remove();

                    //$('.inputdelay').fadeOut();
                    $('#myCanvas').show();
                    // Get the canvas element.
                    var elem = document.getElementById('myCanvas');
                    if (!elem || !elem.getContext) {
                        return;
                    }
                    // Get the canvas 2d context.
                    context = elem.getContext('2d');
                    if (!context || !context.drawImage) {
                        return;
                    }

                    // Once it's loaded draw the image on the canvas.
                    img.addEventListener('load', function () {
                        // Now resize the image: x, y, w, h.
                        //context.drawImage(this, 0, 0, imgFinWidth, imgFinHeight);
                    }, false);

                    img.src = bgimage;

                    context.fillStyle    = '#000';
                    context.textBaseline = 'top';
                }
                if (state == 'h') {
                    $('#hack').slideDown();
                }
            }

            checkMode();

            // check for edit mode change
            $('#editmode_form input:radio').change(function() {
                checkMode();
            });


            function sumDigits(s) {
                s = s + "";
                var r = 0;
                for (i = 0; i < s.length; i++) {
                    //console.log(parseInt(s.charAt(i)));
                    r = r + parseInt(s.charAt(i));
                }
                return r;
            }

            var currentWord = 0;

            var tempWord = null;

            // This is called every 10 ms

            function checkTime() {

                // Check for selected text
                //console.log('selectEnd='+selectEnd);

                if (selectEnd != null) {
                    //console.log('checking highlight');
                    //console.log('selectStart = '+selectStart);
                    //console.log('selectEnd = '+selectEnd);
                    //console.log('selectPlaying = '+selectPlaying);
                }

                if (selectStart != null && selectPlaying == false) {
                    //.log("PLAY FROM THIS POINT "+wordTimes[selectStart]);
                    $("#jquery_jplayer").jPlayer("playHeadTime", wordTimes[selectStart]);
                    selectPlaying = true;
                }

                if (selectEnd == (currentWord-1) && selectPlaying == true) {
                    $("#jquery_jplayer").jPlayer("pause");
                    selectPlaying = false;
                }


                //var audio = $('#jquery_jplayer audio').get(0);
                if (wordTimes.length > 0) {
                    //var currentTime = audio.currentTime;

                    var currentTime = $('#jquery_jplayer').jPlayer("getData", "diag.playedTime");

                    if (currentWord != tempWord){
                        //console.log("["+(currentWord-1)+"] "+word[currentWord-1]);
                        tempWord = currentWord;
                    }

                    if ($('#myCanvas').is(":visible") && !audioEnded) {
                        var offSetX = currentTime/100;
                        var offSetY = currentTime/200;

                        // Shift the image slowly

                        context.drawImage(img, offSetX, offSetY, imgOriWidth, imgOriHeight, 0, 0, imgFinWidth, imgFinHeight);

                        // Check to see whether we should display a word in canvas
                        if (word[currentWord-1] != null && word[currentWord-1] != "" && currentTime > wordTimes[currentWord-1]) {

                            /*var sumX = sumDigits(wordTimes[currentWord-1]);
                            var sumY = sumDigits(wordTimes[currentWord]);
                            var relOffSetX =  (currentTime - wordTimes[currentWord-1])/100;      */

                            context.font         = 'bold '+offSetX+'px sans-serif';
                            context.globalAlpha = 0.5;

                            context.fillText(word[currentWord-1], 0+offSetX, 50+offSetY);
                            context.globalAlpha = 1.0;
                        }
                    }


                    if (wordTimes[currentWord] == null && currentWord < wordTimes.length) {
                        currentWord++;
                    } else {
                        // check whether the time has arrived to display the word

                        if (audioEnded == false && currentTime >= wordTimes[currentWord] && (currentWord >= (wordTimes.length-1)  || currentTime <= wordTimes[currentWord+1] )) {
                            //highlight word
                            highlightWord(currentWord);
                            currentWord++;
                        } else {
                            // Fast forward to the corresponding word

                            while ((currentTime > wordTimes[currentWord+1]) && (currentWord < wordTimes.length )) {
                                currentWord++;
                            }

                            // Rewind to the corresponding word

                            while ((currentTime < wordTimes[currentWord-1]) && (currentWord >= 0)) {
                                currentWord--;
                            }
                        }
                    }

                    //if (currentWord > wordTimes.length) currentWord = 0;
                }
            }

            $('#hackbtn').click(function(){
                bgimage = ($('#imageedit').val());
                word = $('#textedit').val().split(" ");
                $('#textcontent').text('');
                wrapWords();
                wordTimes = $('#timingsedit').val().split(",");
                for (i=0; i < wordTimes.length; i++) {
                    wordTimes[i] = parseInt(wordTimes[i]);
                }

                imgOriWidth = $('#oriwidth').val();
                imgFinWidth = $('#finwidth').val();
                imgOriHeight = $('#oriheight').val();
                imgFinHeight = $('#finheight').val();
                //console.dir(wordTimes);
            });
        });




        -->
    </script>
</head>
<body>

<div id="jquery_jplayer"></div>

<div class="jp-single-player">
    <div class="jp-interface">
        <ul class="jp-controls">
            <li><a href="#" id="jplayer_play" class="jp-play" tabindex="1">play</a></li>
            <li><a href="#" id="jplayer_pause" class="jp-pause" tabindex="1">pause</a></li>
            <li><a href="#" id="jplayer_stop" class="jp-stop" tabindex="1">stop</a></li>
            <li><a href="#" id="jplayer_volume_min" class="jp-volume-min" tabindex="1">min volume</a></li>
            <li><a href="#" id="jplayer_volume_max" class="jp-volume-max" tabindex="1">max volume</a></li>
        </ul>
        <div class="jp-progress">
            <div id="jplayer_load_bar" class="jp-load-bar">
                <div id="jplayer_play_bar" class="jp-play-bar"></div>
            </div>
        </div>
        <div id="jplayer_volume_bar" class="jp-volume-bar">
            <div id="jplayer_volume_bar_value" class="jp-volume-bar-value"></div>
        </div>
        <div id="jplayer_play_time" class="jp-play-time"></div>
        <div id="jplayer_total_time" class="jp-total-time"></div>
    </div>
    <div id="jplayer_playlist" class="jp-playlist">
        <ul>
            <li>{{ $item->name }}</li>
        </ul>
    </div>
    <a href="{{ asset('/storage/audios'). '/' .$item->audio_file }}" id="track_url"></a>
    <a href="{{ asset('/storage/waveforms'). '/' .$item->waveform }}" id="track_waveform"></a>
</div>



<form id="editmode_form">
    <fieldset>
        <label for="editmode"><input id="defaultstate" name="editmode" type="radio" value="y" checked="checked"> Sync Mode</label>
        <label for="editmode"><input name="editmode" type="radio" value="n"> Playback Mode</label>
        <label for="editmode"><input name="editmode" type="radio" value="v"> Image Overlay Mode</label>
        <label for="editmode"><input name="editmode" type="radio" value="h"> Hack</label>

        <!-- hidden for now -->
        <div style="display:none" class="inputdelay"><label for="delay">Word delay (ms)</label><a href="#">-</a><input name="delay" type="text" value="0" size="4"><a href="#">+</a></div>
    </fieldset>

    <div class="instructions">
        <p id="synctext">Press the space-bar, the sync button or click on the words to synchronise with audio.</p>
        <p id="playtext">Press play to see the words synchronised with audio. </br>Click the words to jump directly to the associated audio.</p>
    </div>

    <p id="textcontent">{{$item->text}}</p>

    <a href="#" id="syncbtn" class="actionbtn">Sync</a>

    <span class="action" id="selected" style="display:none">selected</span>
    <fieldset id="hack">
        <textarea id="textedit" cols="40" rows="4"></textarea>
        <textarea id="timingsedit" cols="40" rows="4"></textarea>
        <input id="imageedit" type="text" />
        <p>
            <input id="oriwidth" type="text" size="4" />
            <input id="oriheight" type="text" size="4" />
            <input id="finwidth" type="text" size="4" />
            <input id="finheight" type="text" size="4" />
        </p>
        <input id="hackbtn" type="button" value="update">
    </fieldset>
</form>
<canvas id="myCanvas" width="1430" height="750" style="display:none">
    Your browser does not support for Canvas.
</canvas>
</body>
</html>
