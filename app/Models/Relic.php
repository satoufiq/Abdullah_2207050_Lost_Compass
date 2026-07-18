<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relic extends Model
{
    protected $fillable = [
        'name',
        'description',
        'image',
        'rarity',
    ];

    public function userRelics()
    {
        return $this->hasMany(UserRelic::class);
    }
}
