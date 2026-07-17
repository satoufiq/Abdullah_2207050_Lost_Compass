<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TavernPost extends Model
{
    protected $fillable = ['user_id', 'title', 'content', 'likes_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(TavernComment::class);
    }

    public function likes()
    {
        return $this->hasMany(TavernLike::class);
    }
}
