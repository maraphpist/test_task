<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Audio;
use Illuminate\Http\Request;
use StarterKit\Core\Services\MediaService\MediaService;

class HomeController extends Controller
{
    public function __construct(MediaService $mediaService, Audio $audio)
    {
        $this->mediaService = $mediaService;
        $this->audio = $audio;
    }

    public function index()
    {
        $items = $this->audio->orderBy('order')->paginate(25);
        return view('front.index', [
            'items' => $items,
        ]);
    }

    public function play($id)
    {
        $item = $this->audio->find($id);
        return view('front.item', [
            'item' => $item,
        ]);
    }
}
