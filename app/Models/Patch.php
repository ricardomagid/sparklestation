<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Character;
use App\Models\Lightcone;
use App\Models\StoryArc;


class Patch extends Model
{
    use HasFactory;

    protected $casts = [
        'start_date' => 'datetime',
    ];

    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    public function lightcones(): HasMany
    {
        return $this->hasMany(Lightcone::class);
    }

    public function storyArc(): BelongsTo
    {
        return $this->belongsTo(StoryArc::class);
    }

    /**
     * Split items (characters or lightcones) into two halves by rarity
     *
     * First Half: first 5★ item + all 4★ items
     * Second Half: remaining 5★ items
     */
    public function splitByHalf($items)
    {
        $firstFiveStar = $items->where('rarity', 5)->first();

        $allFourStars = $items->where('rarity', 4)->values();

        $remainingFiveStars = $items->where('rarity', 5)->slice(1)->values();

        return [
            0 => collect([$firstFiveStar])->filter()->merge($allFourStars),
            1 => $remainingFiveStars
        ];
    }

    /**
     * Get patch characters and lightcones grouped into halves.
     * 
     */
    public function getPatchItemsByHalf()
    {
        $characters = $this->splitByHalf($this->characters);
        $lightcones = $this->splitByHalf($this->lightcones);

        return [
            0 => [
                $characters[0],
                $lightcones[0]
            ],
            1 => [
                $characters[1],
                $lightcones[1]
            ]
        ];
    }

    public function getFormattedNumberAttribute()
    {
        return number_format($this->number, 1);
    }

    public function getImgAttribute()
    {
        return asset(("images/patches/$this->formatted_number.webp"));
    }

    public function getEndDateAttribute()
    {
        return $this->start_date->addDays($this->duration);
    }

    public function getFormattedDurationAttribute() 
    {
        return $this->start_date->format('M j') . ' - ' . $this->end_date->format('M j, Y');
    }
}
