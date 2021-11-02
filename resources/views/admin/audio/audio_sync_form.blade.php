<form action="{{$formAction}}" method="post" id="syncAudioForm" class="ajax" data-ui-block-type="element" data-ui-block-element="#largeModal .modal-body">
    <fieldset>
        <div class="form-group">
            <label for="name">Название аудио файла</label>
            <input type="text" class="form-control" id="name" name="name" @if(isset($item->name)) value="{{$item->name}}" @endif>
            <p class="help-block"></p>
        </div>
    </fieldset>
    @if(file_exists(public_path('storage/audios/').$item->audio_file))
    <fieldset>
        <audio controls  id="player">
            <source src="{{url('storage/audios/' . $item->audio_file)}}">
        </audio>
        <button id="play">Play</button>
        <button id="pause">Pause</button>
        <progress id="seekbar" value="0" max="1" style="width:400px; background: {{url('storage/waveforms/' . $item->waveform)}}"></progress>
    </fieldset>
    @endif
    <fieldset>
        <div class="form-group">
            <label for="text">Текст для аудио файла</label>
            <textarea class="form-control" id="text" name="text" cols="50" rows="5">
                @if(isset($item->text)) {{$item->text}} @endif
            </textarea>
            <p class="help-block"></p>
        </div>
    </fieldset>
    <button class="btn btn-sm btn-info" type="submit">{{$buttonText}}</button>
</form>
<script>
    $('#play').on('click', function() {
        document.getElementById('player').play();
    });

    $('#pause').on('click', function() {
        document.getElementById('player').pause();
    });

    $('#player').on('timeupdate', function() {
        $('#seekbar').attr("value", this.currentTime / this.duration);
    });
</script>
