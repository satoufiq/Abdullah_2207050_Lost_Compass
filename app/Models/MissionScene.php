<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionScene extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'mission_id',
        'title',
        'scene_text',
        'image',
        'is_ending',
        'outcome_type',
        'rewards',
    ];

    protected $casts = [
        'is_ending' => 'boolean',
        'rewards' => 'array',
    ];

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function choices()
    {
        return $this->hasMany(MissionChoice::class, 'scene_id');
    }
}
