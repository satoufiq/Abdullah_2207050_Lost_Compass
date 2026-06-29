<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ship extends Model
{
    protected $fillable = [
        'name',
        'image',
        'description',
        'captain_id',
        'type',
        'speed',
        'attack_power',
        'defense',
        'curse_level',
        'weapons',
        'history',
        'fate',
        'curse',
        'short_power',
        'tags',
        'legend_rank'
    ];

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    public function captain()
    {
        return $this->belongsTo(Captain::class);
    }

    public function missions(): HasMany
    {
        return $this->hasMany(Mission::class);
    }
}
