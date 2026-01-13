<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\RelicPiece;
use Illuminate\Support\Str;
use App\Traits\HighlightNumbersTrait;
use App\Traits\HasFuzzyRouteBinding;
use App\Traits\WordMatchTrait;
use App\Traits\GetSetBonus;

class Relic extends Model
{
    use HasFactory;
    use HighlightNumbersTrait;
    use HasFuzzyRouteBinding;
    use WordMatchTrait;
    use GetSetBonus;

    public function relicPieces(): HasMany
    {
        return $this->hasMany(RelicPiece::class);
    }

    public function getImgAttribute()
    {
        return asset("images/relics/{$this->slug}.webp");
    }

    public function getEffects()
    {
        return [
            'firstset' => $this->first_effect ?? null,
            'secondset' => $this->second_effect ?? null
        ];
    }

    /**
     * Get the first effect with numbers highlighted.
     */
    public function getHighlightedFirstEffect()
    {
        return $this->first_effect ? $this->highlightNumbers($this->first_effect) : null;
    }

    /**
     * Get the second effect with numbers highlighted.
     */
    public function getHighlightedSecondEffect()
    {
        return $this->second_effect ? $this->highlightNumbers($this->second_effect) : null;
    }

    protected function baseQuery()
    {
        return self::with([
            'relicPieces' => function($query) {
                $query->with(['type', 'relicSet']);
            }
        ]);
    }
}
