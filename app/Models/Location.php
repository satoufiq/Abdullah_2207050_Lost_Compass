<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'type',
        'description',
        'danger_level',
        'image',
        'icon',
        'icon_label',
        'x_position',
        'y_position'
    ];

    public function missions()
    {
        return $this->hasMany(Mission::class, 'location_id', 'id');
    }

    public function characters()
    {
        return $this->hasMany(Character::class, 'primary_location_id', 'id');
    }
}
