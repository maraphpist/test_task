<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use StarterKit\Core\Traits\HasMedia;

class Audio extends Model
{
    use HasMedia;
    use HasTranslations;
    protected $table = 'audios';
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'audio_file' => 'object',
    ];

    protected $fillable = [
        'name',
        'audio_file',
        'waveform',
        'duration',
        'text',
        'linked_text',
        'order'
    ];
}
