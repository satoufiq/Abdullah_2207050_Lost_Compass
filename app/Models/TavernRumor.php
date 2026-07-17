<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TavernRumor extends Model
{
    protected $fillable = ['content', 'source', 'is_active'];
}
