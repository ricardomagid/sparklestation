<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\RelicType;
use App\Models\PlanarOrnament;
use App\Traits\HasRelicGeneration;
use Illuminate\Support\Str;

class PlanarOrnamentPiece extends Model
{
    use HasFactory;
    use HasRelicGeneration;

    protected $appends = ['img']; 

    public function type(): BelongsTo
    {
        return $this->belongsTo(RelicType::class, 'relic_type', 'id');
    }

    public function planarSet(): BelongsTo
    {
        return $this->belongsTo(PlanarOrnament::class, 'planar_ornament_id');
    }

    public function getImgAttribute()
    {
        $filename = $this->planarSet->slug . "-" . Str::slug($this->type->name);

        return asset("images/relics/{$filename}.webp");
    }
}
