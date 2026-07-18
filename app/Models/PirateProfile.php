<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PirateProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'pirate_name',
        'rank',
        'ship',
        'allegiance',
        'avatar',
        'relic',
        'identity_character',
        'weapon',
        'motto',
        'emblem',
    ];

    /**
     * Get the user that owns the pirate profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
