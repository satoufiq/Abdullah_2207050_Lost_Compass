<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRelic extends Model
{
    protected $fillable = [
        'user_id',
        'relic_id',
        'acquired_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function relic()
    {
        return $this->belongsTo(Relic::class);
    }
}
