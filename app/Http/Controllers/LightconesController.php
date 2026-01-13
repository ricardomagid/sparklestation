<?php

namespace App\Http\Controllers;

use App\Models\Lightcone;
use App\Models\Path;
use Illuminate\Http\Request;

class LightconesController extends Controller
{
    public function index()
    {
        try {
            $lightcones = Lightcone::with(['path', 'stats'])
                ->orderBy('id', 'desc')
                ->get();

            $paths = Path::all();
        } catch (\Exception $e) {
            $lightcones = collect();
            $paths = collect();
        }

        return view('lightcones.index', [
            'lightcones' => $lightcones,
            'paths' => $paths,
        ]);
    }

    public function show(Lightcone $lightcone)
    {
        // Retrieve highest values for each stat accross all lightcones at level 80
        $maxStatValues = $this->getMaxStatValues();
        $stats = $lightcone->stats;

        return view('lightcones.show', compact('lightcone', 'stats', 'maxStatValues'));
    }

    /**
     * Get the highest possible stat values at max level across all lightcones
     * 
     * Uses Laravel collections to efficiently process all lightcones:
     * 1. Maps each lightcone to their level 90 stats
     * 2. Reduces the collection to find the maximum value for each stat
     * 
     * @param int $level The level to calculate stats for (default: 80)
     * @return array Highest possible values for each stat
     */
    public function getMaxStatValues($level = 80)
    {
        return Lightcone::all()
            ->map(fn($char) => $char->getStatsAtLevel($level))
            ->reduce(function ($carry, $stats) {
                return [
                    'hp' => max($carry['hp'], $stats['hp']),
                    'atk' => max($carry['atk'], $stats['atk']),
                    'def' => max($carry['def'], $stats['def']),
                ];
            }, ['hp' => 0, 'atk' => 0, 'def' => 0]);
    }
}
