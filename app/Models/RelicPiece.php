<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\RelicType;
use App\Models\Relic;
use App\Traits\HasRelicGeneration;
use Illuminate\Support\Str;

class RelicPiece extends Model
{
    use HasFactory;
    use HasRelicGeneration;

    protected $appends = ['img']; 

    public function type(): BelongsTo
    {
        return $this->belongsTo(RelicType::class, 'relic_type', 'id');
    }

    public function relicSet(): BelongsTo
    {
        return $this->belongsTo(Relic::class, 'relic_id');
    }

    public function getImgAttribute()
    {
        $filename = Str::slug($this->relicSet->name) . "-" . Str::slug($this->type->name);

        return asset("images/relics/{$filename}.webp");
    }
}
