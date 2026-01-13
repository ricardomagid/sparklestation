<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PlanarOrnamentPiece;
use Illuminate\Support\Str;
use App\Traits\HighlightNumbersTrait;
use App\Traits\HasFuzzyRouteBinding;
use App\Traits\WordMatchTrait;
use App\Traits\GetSetBonus;

class PlanarOrnament extends Model
{
    use HasFactory;
    use HighlightNumbersTrait;
    use HasFuzzyRouteBinding;
    use WordMatchTrait;
    use GetSetBonus;

    public function planarOrnamentPieces(): HasMany
    {
        return $this->hasMany(PlanarOrnamentPiece::class, 'planar_ornament_id');
    }

    public function getImgAttribute()
    {
        return asset("images/relics/{$this->slug}.webp");
    }

    public function getEffects()
    {
        return [
            'firstset' => $this->effect ?? null        
        ];
    }

    /**
     * Get the  effect with numbers highlighted.
     */
    public function getHighlightedFirstEffect()
    {
        return $this->effect ? $this->highlightNumbers($this->effect) : null;
    }

    protected function baseQuery()
    {
        return self::with([
            'planarOrnamentPieces' => function($query) {
                $query->with(['type', 'planarSet']);
            }
        ]);
    }
}
