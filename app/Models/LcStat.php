<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Lightcone;

class LcStat extends Model
{
    use HasFactory;

    public function lightcone(): BelongsTo
    {
        return $this->belongsTo(Lightcone::class);
    }
}
