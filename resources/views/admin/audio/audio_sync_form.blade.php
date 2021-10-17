<form action="{{$formAction}}" method="post" id="syncAudioForm" class="ajax" data-ui-block-type="element" data-ui-block-element="#largeModal .modal-body">
    <fieldset>
        <div class="form-group">
            <label for="name">Название аудио файла</label>
            <input type="text" class="form-control" id="name" name="name" @if(isset($item->name)) value="{{$item->name}}" @endif>
            <p class="help-block"></p>
        </div>
    </fieldset>
    <fieldset>
{{--        тут типа будет аудио плеер--}}
    </fieldset>
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
