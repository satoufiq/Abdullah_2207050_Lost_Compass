<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CharacterRelation extends Model
{
    protected $fillable = [
        'character_id',
        'related_name',
        'relation_type',
    ];

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'character_id', 'id');
    }
}
