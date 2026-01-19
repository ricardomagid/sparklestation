<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trace extends Model
{
    use HasFactory;

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    public function main_trace_img($i)
    {
        return asset("images/traces/{$this->character->slug}-" . str_pad($i, 2, '0', STR_PAD_LEFT) . ".webp");
    }
}