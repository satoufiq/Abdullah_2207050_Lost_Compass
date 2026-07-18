<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gold',
        'reputation',
        'relics',
    ];

    protected $casts = [
        'relics' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
