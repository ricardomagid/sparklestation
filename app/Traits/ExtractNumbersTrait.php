<?php

namespace App\Traits;

trait ExtractNumbersTrait
{
    /**
     * Get all numeric values in the raw description as an array
     *
     * @return array<int, string>
     */
    public function getBaseNumbersAttribute(): array
    {
        preg_match_all('/\d+(\.\d+)?/', $this->description ?? '', $matches);
        return $matches[0] ?? [];
    }
}