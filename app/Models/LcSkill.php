<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HighlightNumbersTrait;
use App\Traits\ExtractNumbersTrait;


class LcSkill extends Model
{
    use HasFactory;
    use HighlightNumbersTrait;
    use ExtractNumbersTrait;

    protected $casts = [
        'positions' => 'array', 
        'differences' => 'array'
    ];

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