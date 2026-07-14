<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'pirate_name',
        'identity_character',
        'ship',
        'weapon',
        'relic',
        'allegiance',
        'rank',
        'avatar',
    ];

    /**
     * Check if the user is an administrator.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the pirate profile associated with the user.
     */
    public function rewards()
    {
        return $this->hasOne(UserReward::class);
    }

    public function pirateProfile(): HasOne
    {
        return $this->hasOne(PirateProfile::class);
    }

    /**
     * Get the user's mission progress records.
     */
    public function userMissions(): HasMany
    {
        return $this->hasMany(UserMission::class);
    }

    /**
     * Get the user's notifications.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function userRelics(): HasMany
    {
        return $this->hasMany(UserRelic::class);
    }

    public function relicHistories(): HasMany
    {
        return $this->hasMany(RelicHistory::class);
    }

    /**
     * Get the user's avatar image URL.
     * If they haven't uploaded one, return a dynamically generated pirate/adventurer avatar.
     */
    public function getAvatarUrlAttribute()
    {
        $avatarFile = $this->avatar;

        if ($avatarFile) {
            // If the exact file exists, return it
            if (file_exists(public_path("assets/images/profile/avatars/{$avatarFile}"))) {
                return asset("assets/images/profile/avatars/{$avatarFile}");
            }
            
            // Fallback logic for quiz generated avatars that might not exist on disk exactly
            $parts = explode('-', str_replace('.png', '', $avatarFile)); 
            $role = $parts[1] ?? 'captain';
            
            $existingAvatars = glob(public_path('assets/images/profile/avatars/avatar-*.png'));
            if ($existingAvatars) {
                foreach ($existingAvatars as $f) {
                    $base = basename($f);
                    if (str_contains($base, "avatar-{$role}-")) {
                        return asset("assets/images/profile/avatars/{$base}");
                    }
                }
            }
            
            // Ultimate local fallback if nothing matches
            return asset('assets/images/profile/avatars/avatar-captain-fearless.png');
        }

        // If they didn't take the quiz (avatar is null), use the DiceBear API!
        $seed = urlencode($this->pirate_name ?? $this->name);
        return "https://api.dicebear.com/9.x/adventurer/svg?seed={$seed}&backgroundColor=c0a080"; 
    }
}
