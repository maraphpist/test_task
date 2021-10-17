@foreach($items as $item)
    @include('admin.audio.item')
@endforeach

@if(!$items->count())
    <tr>
        <td colspan="5" class="text-center">Данных не найдено</td>
    </tr>
@endif
