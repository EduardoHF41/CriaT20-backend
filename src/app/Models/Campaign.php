<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'description',
        'gm_user_id',
        'invite_code',
    ];

    protected static function booted(): void
    {
        static::creating(function (Campaign $campaign) {
            if (empty($campaign->invite_code)) {
                $campaign->invite_code = self::generateInviteCode();
            }
        });
    }

    public static function generateInviteCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::query()->where('invite_code', $code)->exists());

        return $code;
    }

    public function gm()
    {
        return $this->belongsTo(User::class, 'gm_user_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'campaign_members')->withTimestamps();
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    /**
     * O usuário é o mestre ou um membro da campanha?
     */
    public function hasParticipant(int $userId): bool
    {
        return $this->gm_user_id === $userId
            || $this->members()->where('users.id', $userId)->exists();
    }
}
