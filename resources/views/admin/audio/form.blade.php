<form action="{{$formAction}}" method="post" id="audioForm" class="ajax" data-ui-block-type="element" data-ui-block-element="#largeModal .modal-body">
    <fieldset>
        <div class="form-group">
            <label for="name">Название аудио файла</label>
            <input type="text" class="form-control" id="name" name="name" @if(isset($item->name)) value="{{$item->name}}" @endif>
            <p class="help-block"></p>
        </div>
    </fieldset>
    <fieldset>
        <div class="form-group">
            <label for="audio_file">Аудио файл</label>
            <input type="file" accept="audio/mpeg" class="form-control" id="audio_file" name="audio_file" placeholder="">
            <p class="help-block"></p>
        </div>
        <fieldset>
            @if(isset($item->audio_file))
                <p>{{ $item->audio_file }}</p>
            @endif
        </fieldset>
    </fieldset>
    <fieldset>
        <div class="form-group">
            <label for="text">Текст для аудио файла</label>
            <textarea class="form-control" id="text" name="text" cols="50" rows="5">@if(isset($item->text)){{$item->text}}@endif</textarea>
            <p class="help-block"></p>
        </div>
    </fieldset>
    <fieldset>
        <legend>Порядок</legend>
        <div class="form-group">
            <label for="order">Введите порядковый номер для элемента</label>
            <input type="number" class="form-control" id="order" name="order"
                   @if(isset($item->order)) value="{{$item->order}}" @endif
                   placeholder="0" min="0" max="999">
            <p class="help-block"></p>
        </div>
    </fieldset>
    <button class="btn btn-sm btn-info" type="submit">{{$buttonText}}</button>
</form>
