<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Character;

class CharStat extends Model
{
    use HasFactory;

    public function char(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}
