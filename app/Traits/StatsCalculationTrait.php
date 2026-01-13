<?php

namespace App\Traits;

/**
 * Trait for calculating level-based stats
 * Shared between Character and Lightcone models
 */
trait StatsCalculationTrait
{
    /**
     * Calculate stats for a specific level
     * 
     * @param int $level Entity level
     * @return array Stats at the specified level
     */
    public function getStatsAtLevel($level)
    {
        $baseStats = $this->stats;
        $multiplier = $this->calculateLevelMultiplier($level);
        
        return [
            'atk' => $baseStats->atk * $multiplier,
            'hp' => $baseStats->hp * $multiplier,
            'def' => $baseStats->def * $multiplier,
            'speed' => $baseStats->speed ?? 0
        ];
    }

    /**
     * Generate a table of stats for all levels
     * 
     * @param int $maxLevel Maximum level to calculate (default: 80)
     * @return array Stats table indexed by level
     */
    public function getStatsTable($maxLevel = 80)
    {
        $data = [];
        $baseStats = $this->stats;
        
        for ($level = 1; $level <= $maxLevel; $level++) {
            $multiplier = $this->calculateLevelMultiplier($level);
            
            $data[$level] = [
                'atk' => $baseStats->atk * $multiplier,
                'hp' => $baseStats->hp * $multiplier,
                'def' => $baseStats->def * $multiplier
            ];
        }
        
        return $data;
    }

    /**
     * Abstract method that must be implemented by models using this trait
     * Each model will implement its own ascension bonus logic
     * 
     * @param int $level Entity level
     * @return float The level multiplier including ascension bonuses
     */
    abstract protected function calculateLevelMultiplier($level);
}

?>