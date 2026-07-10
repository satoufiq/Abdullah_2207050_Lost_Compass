<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mission extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'location',
        'location_id',
        'difficulty',
        'featured',
        'ship_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'featured' => 'boolean',
        ];
    }

    /**
     * Scope: only featured missions.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    /**
     * The users that have this mission assigned.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_missions')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function scenes()
    {
        return $this->hasMany(MissionScene::class);
    }

    public function choices()
    {
        return $this->hasManyThrough(MissionChoice::class, MissionScene::class, 'mission_id', 'scene_id', 'id', 'id');
    }

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }

    public function location_model()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
