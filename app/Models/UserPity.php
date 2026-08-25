<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class UserPity extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'rarity',
        'pity',
        'guaranteed',
    ];

    protected $casts = [
        'rarity' => 'integer',
        'pity' => 'integer',
        'guaranteed' => 'boolean',
    ];

    public $timestamps = false;

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }
}