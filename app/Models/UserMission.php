<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMission extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'user_missions';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'mission_id',
        'status',
        'current_scene_id',
        'reward_claimed',
    ];

    protected $casts = [
        'reward_claimed' => 'boolean',
    ];

    /**
     * Get the user for this mission record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the mission for this record.
     */
    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }
}
