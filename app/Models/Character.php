<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Character extends Model
{
    // String primary key
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'role',
        'short_line',
        'quote',
        'category',
        'tags',
        'image',
        'biography',
        'weapon',
        'first_appearance',
        'ship_name',
        'primary_location_id'
    ];

    protected $casts = [
        'tags' => 'array', // automatically handles JSON casting
    ];

    public function primaryLocation()
    {
        return $this->belongsTo(Location::class, 'primary_location_id', 'id');
    }

    public function relations(): HasMany
    {
        return $this->hasMany(CharacterRelation::class, 'character_id', 'id');
    }

    public function allies()
    {
        return $this->relations()->where('relation_type', 'ally');
    }

    public function enemies()
    {
        return $this->relations()->where('relation_type', 'enemy');
    }
}
