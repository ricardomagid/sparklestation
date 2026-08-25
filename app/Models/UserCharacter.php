<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Character;

class UserCharacter extends Model
{
    protected $fillable = [
        'user_id',
        'character_id',
        'eidolon',
        'copies_available',
    ];

    protected $casts = [
        'eidolon' => 'integer',
        'copies_available' => 'integer',
    ];

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function character(): BelongsTo 
    {
        return $this->belongsTo(Character::class);
    }
}