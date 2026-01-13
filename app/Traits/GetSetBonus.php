<?php

namespace App\Traits;

trait GetSetBonus
{
    const BONUS = ['ATK', 'HP', 'DEF', 'SPD', 'Crit Rate', 'Crit DMG', 'Advanced Foward', 'Energy', 'Outgoing Healing', 'Effect Hit Rate', 'Effect RES', 'DoT', 'Break Effect', 'Break DMG', 'Skill Point', 'Follow-up Attack', 'Memosprite', 'Physical DMG', 'Fire DMG', 'Ice DMG', 'Quantum DMG', 'Lightning DMG', 'Wind DMG', 'Imaginary DMG'];
    
    public function getSetBonus()
    {
        $effects = $this->getEffects();
        $setBonus = [];

        foreach(self::BONUS as $bonus) {
            foreach($effects as $effect) {
                if ($effect !== null && stripos($effect, $bonus) !== false) {
                    $setBonus[] = $bonus;
                    break; 
                }
            }
        }
        
        return $setBonus;
    }
}