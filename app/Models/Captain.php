<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Captain extends Model
{
    protected $fillable = [
        'name',
        'image',
    ];

    public function ships(): HasMany
    {
        return $this->hasMany(Ship::class);
    }
}
