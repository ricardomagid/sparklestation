<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Element;
use App\Models\Path;
use App\Models\CharAbility;
use Illuminate\Http\Request;

class CharactersController extends Controller
{
    public function index() 
    {
        try {
            $characters = Character::with(['element', 'path', 'faction', 'stats'])
                ->orderBy('id', 'desc')
                ->get();

            $elements = Element::all();
            $paths = Path::all();
        } catch (\Exception $e) {
            $characters = collect();
            $elements = collect();
            $paths = collect();
        }

        return view('characters.index', [
            'characters' => $characters,
            'elements' => $elements,
            'paths' => $paths,
        ]);
    }

    public function show(Character $character)
    {
        $character->grouped_abilities = $character->abilities->groupBy(fn($a) => $a->ability->name);
        if ($character->name === "Cyrene") {
            if (isset($character->grouped_abilities['Memosprite Skill'])) {
                $character->grouped_abilities['Memosprite Skill'] = $character->grouped_abilities['Memosprite Skill']->filter(fn($a) => !str_contains($a->name, "Ode to"));
            }
        }
        $character->trace_materials = $character->getTraceMaterials();
        $character->total_minor_traces = $character->getTotalMinorTraces();

        $imgs = [];
        foreach ($character->total_minor_traces as $stat => $value) {
            $imgs[$stat] = $character->getMinorTraceImg($stat);
        }
        $character->total_minor_traces_imgs = $imgs;

        $stats = $character->stats;
        // Retrieve highest values for each stat accross all characters at level 80
        $maxStatValues = $this->getMaxStatValues();
        $storyParts = $character->getFormattedStoryParts();

        return view('characters.show', compact('character', 'stats', 'maxStatValues', 'storyParts'));
    }

    /**
     * Get the highest possible stat values at max level across all characters
     * 
     * Uses Laravel collections to efficiently process all characters:
     * 1. Maps each character to their level 90 stats
     * 2. Reduces the collection to find the maximum value for each stat
     * 
     * @param int $level The level to calculate stats for (default: 80)
     * @return array Highest possible values for each stat
     */
    public function getMaxStatValues($level = 80)
    {
        return Character::all()
            ->map(fn($char) => $char->getStatsAtLevel($level))
            ->reduce(function ($carry, $stats) {
                return [
                    'hp' => max($carry['hp'], $stats['hp']),
                    'atk' => max($carry['atk'], $stats['atk']),
                    'def' => max($carry['def'], $stats['def']),
                    'speed' => max($carry['speed'], $stats['speed']),
                ];
            }, ['hp' => 0, 'atk' => 0, 'def' => 0, 'speed' => 0]);
    }
}
