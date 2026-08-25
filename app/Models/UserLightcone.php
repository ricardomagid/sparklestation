<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Lightcone;

class UserLightcone extends Model
{
    protected $fillable = [
        'user_id',
        'lightcone_id',
        'superimposition',
        'copies_available',
    ];

    protected $casts = [
        'superimposition' => 'integer',
        'copies_available' => 'integer',
    ];

    public function user(): BelongsTo 
    {
        return $this->belongsTo(User::class);
    }

    public function lightcone(): BelongsTo
    {
        return $this->belongsTo(Lightcone::class);
    }
}