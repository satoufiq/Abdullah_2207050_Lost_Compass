<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionChoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'scene_id',
        'choice_text',
        'consequence_text',
        'next_scene_id',
        'sfx',
    ];

    public function scene()
    {
        return $this->belongsTo(MissionScene::class, 'scene_id');
    }
}
