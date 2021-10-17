<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audio;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use StarterKit\Core\Services\MediaService\MediaService;
use function PHPUnit\Framework\fileExists;

class AudioController extends Controller
{
    /**
     * @var Audio
     */
    private $audio;
    /**
     * @var MediaService
     */
    private $mediaService;

    public function __construct(MediaService $mediaService, Audio $audio)
    {
        $this->mediaService = $mediaService;
        $this->audio = $audio;
    }

    public function index()
    {
        return view('admin.audio.index', [
            'title' => 'Аудио файлы',
        ]);
    }

    public function getList()
    {
        $items = $this->audio->orderBy('order')->paginate(25);
        return response()->json([
            'functions' => [
                'updateTableContent' => [
                    'params' => [
                        'selector' => '.ajax-content',
                        'content' => view('admin.audio.list', [
                            'items' => $items,
                        ])->render(),
                        'pagination' => view('core::layouts.pagination', [
                            'links' => $items->links('core::pagination.bootstrap-4'),
                        ])->render(),
                    ]
                ]
            ]
        ]);
    }

    public function create()
    {
        return response()->json([
            'functions' => [
                'updateModal' => [
                    'params' => [
                        'modal' => 'largeModal',
                        'title' => 'Загрузка аудио файла',
                        'content' => view('admin.audio.form', [
                            'formAction' => route('admin.audio.store'),
                            'buttonText' => 'Создать'
                        ])->render(),
                    ]
                ]
            ]
        ]);
    }

    public function store(Request $request)
    {
        $item = $this->audio->create($request->all());

        if ($request->has('audio_file')) {
            $file = $request->file('audio_file');
            $allowedfileExtension = ['mp3', 'mpeg'];
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);

            if ($check) {
                $file->store('audios', 'public');
                $item->audio_file = $file->hashName();

                $ffprobe = FFProbe::create();
                $duration = $ffprobe->format($file)->get('duration');
                $item->duration = round($duration, 2);

                $ffmpeg = FFMpeg::create();
                $audio = $ffmpeg->open($file);

                // Create the waveform
                $waveform = $audio->waveform(1640, 120, array('#00FF00'));
                $waveform->save($item->audio_file . '.png');
                if (file_exists(public_path(). '/' .$item->audio_file . '.png')){
                    if (!file_exists(public_path('storage/waveforms/'))){
                        mkdir(public_path('storage/waveforms/'), 0755, true);
                    }
                    File::move(public_path(). '/' .$item->audio_file . '.png', public_path('storage/waveforms/').$item->audio_file . '.png');
                }
                $item->waveform = $item->audio_file . '.png';
                $item->save();
            }
        }

        return response()->json([
            'functions' => [
                'closeModal' => [
                    'params' => [
                        'modal' => 'largeModal',
                    ]
                ],
                'prependTableRow' => [
                    'params' => [
                        'selector' => '.ajax-content',
                        'content' => view('admin.audio.item', ['item' => $item])->render()
                    ]
                ]
            ]
        ]);
    }

    public function edit($itemId)
    {
        $item = $this->audio->find($itemId);

        if (!$item) {
            $response = new ResponseBuilder();
            $response->showAlert('Ошибка!', 'Элемент не найден');
            $response->closeModal(Modal::LARGE);
            return $response->makeJson();
        }

        return response()->json([
            'functions' => [
                'updateModal' => [
                    'params' => [
                        'modal' => 'largeModal',
                        'title' => 'Редактирование аудио файла',
                        'content' => view('admin.audio.form', [
                            'formAction' => route('admin.audio.update', ['id' => $itemId]),
                            'buttonText' => 'Сохранить',
                            'item' => $item,
                        ])->render(),
                    ]
                ]
            ]
        ]);
    }

    public function update(Request $request, $itemId)
    {
        $old_waveform = null;
        $old_audio = null;

        $item = $this->audio->find($itemId);

        if (isset($item->waveform)) {
            $old_waveform = $item->waveform;
        }
        if (isset($item->audio_file)) {
            $old_audio = $item->audio_file;
        }

        $item->update($request->all());

        if ($request->has('audio_file')) {
            $file = $request->file('audio_file');
            $allowedfileExtension = ['mp3', 'mpeg'];
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $allowedfileExtension);

            if ($check) {
                $file->store('audios', 'public');
                $item->audio_file = $file->hashName();

                $ffprobe = FFProbe::create();
                $duration = $ffprobe->format($file)->get('duration');
                $item->duration = round($duration, 2);

                $ffmpeg = FFMpeg::create();
                $audio = $ffmpeg->open($file);

                // Create the waveform
                $waveform = $audio->waveform(1640, 120, array('#00FF00'));
                $waveform->save($item->audio_file . '.png');
                if (file_exists(public_path(). '/' .$item->audio_file . '.png')){
                    if (!file_exists(public_path('storage/waveforms/'))){
                        mkdir(public_path('storage/waveforms/'), 0755, true);
                    }
                    File::move(public_path(). '/' .$item->audio_file . '.png', public_path('storage/waveforms/').$item->audio_file . '.png');
                }

                if (file_exists(public_path('storage/waveforms/').$old_waveform)){
                    File::delete(public_path('storage/waveforms/').$old_waveform);
                }
                if (file_exists(public_path('storage/audios/').$old_audio)){
                    File::delete(public_path('storage/audios/').$old_audio);
                }
                $item->waveform = $item->audio_file . '.png';
                $item->save();
            }
        }

        return response()->json([
            'functions' => [
                'closeModal' => [
                    'params' => [
                        'modal' => 'largeModal',
                    ]
                ],
                'updateTableRow' => [
                    'params' => [
                        'selector' => '.ajax-content',
                        'row' => '.row-' . $itemId,
                        'content' => view('admin.audio.item',['item' => $item])->render()
                    ]
                ]
            ]
        ]);
    }

    public function delete(int $itemId)
    {
        $item = $this->audio->find($itemId);

        if($item) {
            if (file_exists(public_path('storage/waveforms/').$item->waveform)){
                File::delete(public_path('storage/waveforms/').$item->waveform);
            }
            if (file_exists(public_path('storage/audios/').$item->audio_file)){
                File::delete(public_path('storage/audios/').$item->audio_file);
            }
            $item->delete();
        }

        return response()->json([
            'functions' => [
                'deleteTableRow' => [
                    'params' => [
                        'selector' => '.ajax-content',
                        'row' => '.row-'.$itemId
                    ]
                ]
            ]
        ]);
    }

    public function textAudioSyncEdit($itemId)
    {
        $item = $this->audio->find($itemId);

        if (!$item) {
            $response = new ResponseBuilder();
            $response->showAlert('Ошибка!', 'Элемент не найден');
            $response->closeModal(Modal::LARGE);
            return $response->makeJson();
        }

        return response()->json([
            'functions' => [
                'updateModal' => [
                    'params' => [
                        'modal' => 'largeModal',
                        'title' => 'Синхронизация текста и аудио',
                        'content' => view('admin.audio.audio_sync_form', [
                            'formAction' => route('admin.text.audio.sync.update', ['id' => $itemId]),
                            'buttonText' => 'Сохранить',
                            'item' => $item,
                        ])->render(),
                    ]
                ]
            ]
        ]);
    }

    public function textAudioSyncUpdate(Request $request, $itemId)
    {
//        тут короч еще не готово ничего
        return response()->json([
            'functions' => [
                'closeModal' => [
                    'params' => [
                        'modal' => 'largeModal',
                    ]
                ],
                'updateTableRow' => [
                    'params' => [
                        'selector' => '.ajax-content',
                        'row' => '.row-' . $itemId,
                        'content' => view('admin.audio.item',['item' => $item])->render()
                    ]
                ]
            ]
        ]);
    }
}
