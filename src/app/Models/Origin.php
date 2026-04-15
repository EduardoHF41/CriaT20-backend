<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Origin extends Model
{
    protected $fillable = [
        'name',
        'description',
        'origin_trait',
    ];

    public function features(): HasMany
    {
        return $this->hasMany(OriginFeature::class);
    }

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }
}
