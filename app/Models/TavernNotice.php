<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TavernNotice extends Model
{
    protected $fillable = ['name', 'reward', 'desc', 'image'];
}
