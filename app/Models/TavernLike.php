<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TavernLike extends Model
{
    protected $fillable = ['tavern_post_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(TavernPost::class, 'tavern_post_id');
    }
}
