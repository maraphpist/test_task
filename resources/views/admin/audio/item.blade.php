<tr class="row-{{ $item->id }}"  @if(isset($loop))data-index="{{$loop->iteration}}"@endif>
    <td class="text-center align-middle">{{ $item->id }}</td>
    <td class="text-center align-middle">@if(isset($item->name)){{ $item->name }}@endif</td>
    <td class="text-center align-middle">@if(isset($item->duration)){{ $item->duration }}@endif</td>
    <td class="text-center align-middle">
        @if(isset($item->waveform))
            <img width="480" height="70"
{{--                 {{ dd($item->waveform) }}--}}
                 src="{{ asset('storage/waveforms/' . $item->waveform) }}">
        @else
            Waveform отсутствует
        @endif
    </td>
    <td class="text-center align-middle">
        <i class="la la-power-off" style="color:@if($item->text) green; @else red;@endif"></i>
    </td>
    <td class="text-center align-middle">@if(isset($item->order)){{ $item->order }}@endif</td>
    <td class="text-center align-middle">
        <a href="#" data-url="{{ route('admin.text.audio.sync.edit', ['id' => $item->id ]) }}" class="handle-click" data-type="modal" data-modal="largeModal"
           title="Синхронизация текста и аудио">
            <i class="la la-adjust"></i>
        </a>
    </td>
    <td class="text-center align-middle">
        <a href="#" data-url="{{ route('admin.audio.edit', ['id' => $item->id ]) }}" class="handle-click" data-type="modal" data-modal="largeModal"
            title="Изменить элемент">
            <i class="la la-edit"></i>
        </a>
    </td>
    <td class="text-center align-middle">
        <a href="#" class="handle-click" data-type="confirm"
           title="Удалить"
           data-title="Удаление"
           data-message="Вы уверены, что хотите удалить элемент?"
           data-cancel-text="Нет"
           data-confirm-text="Да, удалить" data-url="{{ route('admin.audio.delete', ['id' => $item->id ]) }}">
            <i class="la la-trash"></i>
        </a>
    </td>
</tr>
