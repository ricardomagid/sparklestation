<?php
namespace App\Traits;

trait HasRelicGeneration
{
    public function randomMainStat(): ?string
    {
        $pieceType = $this->type->name;

        $pool = config("relic_mainstats.$pieceType");

        if (!$pool) return null;

        // Generate a random mainstat
        $total = array_sum(array_column($pool, 'chance'));
        $roll = mt_rand(1, $total);
        $cumulative = 0;

        foreach($pool as $entry) {
            $cumulative += $entry['chance'];
            if ($roll <= $cumulative) {
                return $entry['stat'];
            }
        }

        return null;
    }

    public function randomSubStats(string $mainstat): ?array
    {
        $pool = config("relic_substats");

        if (!$pool || !$mainstat) return [];

        // Remove the substat that matches the mainstat
        unset($pool[$mainstat]);

        // Generate random four substats
        $substats = [];

        for ($i = 0; $i < 4 && count($pool) > 0; $i++) {
            $total = array_sum($pool);
            $roll = mt_rand(1, $total);
            $cumulative = 0;

            foreach ($pool as $stat => $chance) {
                $cumulative += $chance;
                if ($roll <= $cumulative) {
                    $substats[] = $stat;
                    unset($pool[$stat]);
                    break;
                }
            }
        }

        return $substats;
    }
}
?>