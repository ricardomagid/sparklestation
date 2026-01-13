<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Character;
use App\Models\AbilityType;
use App\Models\Ability;
use Illuminate\Support\Str;
use App\Traits\HighlightNumbersTrait;
use App\Traits\ExtractNumbersTrait;

class CharAbility extends Model
{
    use HasFactory;
    use HighlightNumbersTrait;
    use ExtractNumbersTrait;

    protected $casts = [
        'positions' => 'array', 
        'differences' => 'array'
    ];

    protected $appends = ['base_numbers'];

    /**
     * Scope a query to include only abilities of a given type
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type  The name of the ability type to filter by (such as "Basic ATK", "Skill", etc)
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->whereHas('ability', function ($q) use ($type) {
            $q->where('name', $type);
        });
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AbilityType::class, 'ability_type_id');
    }

    public function ability(): BelongsTo
    {
        return $this->belongsTo(Ability::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get the image path for the ability based on character name and optional index.
     *
     * @param int $index Optional index for multiple ability images (default is 1).
     * @return string The full asset URL to the ability image.
     */
    public function img(int $index = 1) {
        $abilityName = Str::slug($this->ability->name);
        $abilityName = ($abilityName == "basic-atk") ? "basic" : $abilityName;
        $characterName = $this->character->slug;

        $basePath = "images/abilities/{$characterName}-{$abilityName}";
        $pathWithSuffix = $basePath . sprintf("%02d", $index) . ".webp";
        $pathWithoutSuffix = $basePath . ".webp";

        if ($index > 1 && file_exists(public_path($pathWithSuffix))) {
            return asset($pathWithSuffix);
        }

        return asset($pathWithoutSuffix);
    }

    /**
     * Get the description attribute with numbers wrapped in <span> tags.
     *
     * This accessor processes the raw 'description' attribute and wraps all
     * numeric values in a <span> element for styling or formatting purposes.
     *
     * @param  string  $value  The raw description value from the database
     * @return string          The processed HTML string with numbers wrapped in <span>
     */
    public function getDescriptionAttribute($value)
    {
        return $this->highlightNumbers($value);
    }
}
