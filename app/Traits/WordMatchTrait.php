<?php

namespace App\Traits;

trait WordMatchTrait
{
    public function findClosestNames(string $query, array $names, int $minLength = 3): array
    {
        $query = strtolower($query);
        $matches = [];

        foreach ($names as $name) {
            $nameLower = strtolower($name);

            // Exact substring
            if (strlen($query) >= $minLength && strpos($nameLower, $query) !== false) {
                $matches[$name] = 100;
                continue;
            }

            // One transposition
            if ($this->isOneTranspositionAway($nameLower, $query)) {
                $matches[$name] = 90;
                continue;
            };

            // Levenshtein distance for small typos
            $distance = levenshtein($query, $nameLower);
            if ($distance <= 2) {
                $matches[$name] = 80 - $distance;
            }
        }

        arsort($matches);

        return array_keys($matches);
    }

    public function isOneTranspositionAway(string $word, string $query): bool
    {
        if (strlen($word) !== strlen($query)) return false;

        $diffIndexes = [];
        for ($i = 0; $i < strlen($word); $i++) {
            if ($word[$i] !== $query[$i]) {
                $diffIndexes[] = $i;
            }
        }

        if (count($diffIndexes) === 2) {
            $i = $diffIndexes[0];
            $j = $diffIndexes[1];

            return $word[$i] === $query[$j] && $word[$j] === $query[$i];
        }

        return false;
    }
}