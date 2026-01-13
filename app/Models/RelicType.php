<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\RelicPiece;
use App\Models\PlanarOrnamentPiece;

class RelicType extends Model
{
    use HasFactory;

    public function relicPieces(): HasMany
    {
        return $this->hasMany(RelicPiece::class);
    }

    public function planarOrnamentPieces(): HasMany
    {
        return $this->hasMany(PlanarOrnamentPiece::class);
    }
}
