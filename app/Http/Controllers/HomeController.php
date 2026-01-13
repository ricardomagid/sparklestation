<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Patch;
use App\Models\ActiveCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // Default values
        $currentPatch = null;
        $characters = collect();
        $randomCharacter = null;
        $activeCodes = collect();
        $charts = [];

        try {
            $currentPatch = Patch::latest('id')->first();
        } catch (\Exception $e) {
            \Log::error('Failed to fetch current patch: ' . $e->getMessage());
        }

        try {
            $characters = Character::with(['patch', 'element', 'path'])->get();

            // Exclude MC
            $filteredCharacters = $characters->filter(fn($character) =>
                in_array(strtolower($character->gender), ['male', 'female'])
            );

            $randomCharacter = $filteredCharacters->random();

            // Helper function to count characters and fetch image URLs
            $groupedData = fn($groupBy, $imagePath) =>
                $characters->groupBy($groupBy)->mapWithKeys(fn($group, $key) => [
                    $key => [
                        'count' => $group->count(),
                        'image_url' => asset("images/{$imagePath}/{$key}.webp"),
                    ]
                ]);

            // Build chart data
            $chartData = collect([
                'elements' => $groupedData(fn($c) => optional($c->element)->name, 'elements'),
                'paths' => $groupedData(fn($c) => optional($c->path)->name, 'paths'),
                'gender' => $filteredCharacters->groupBy('gender')->map(fn($group, $key) => [
                    'count' => $group->count(),
                    'image_url' => null,
                ]),
            ]);

            // Chart configs
            $charts = [
                'elements' => [
                    'title' => 'Character Element Distribution',
                    'labels' => $chartData['elements']->keys()->toArray(),
                    'data' => $chartData['elements']->pluck('count')->toArray(),
                    'images' => $chartData['elements']->pluck('image_url')->toArray(),
                    'defaultToolbar' => false,
                    'colors' => ["#E6E6E6", "#F45D53", "#55A3D5", "#66C38C", "#F1E596", "#E385F1", "#8576CD"],
                ],
                'paths' => [
                    'title' => 'Character Path Distribution',
                    'labels' => $chartData['paths']->keys()->toArray(),
                    'data' => $chartData['paths']->pluck('count')->toArray(),
                    'images' => $chartData['paths']->pluck('image_url')->toArray(),
                    'defaultToolbar' => false,
                ],
                'gender' => [
                    'title' => 'Character Gender Distribution',
                    'labels' => $chartData['gender']->keys()->toArray(),
                    'data' => $chartData['gender']->pluck('count')->toArray(),
                    'images' => [],
                    'defaultToolbar' => true,
                ],
            ];

            // Active Codes
            $activeCodes = ActiveCodes::where('status', 1)
                ->where(fn($q) => $q->where('end_date', '>=', now())
                                    ->orWhereNull('end_date'))
                ->get();

        } catch (\Exception $e) {
            \Log::error('Failed to fetch characters: ' . $e->getMessage());
        }

        return view('home', [
            'currentPatch' => $currentPatch,
            'characters' => $characters,
            'randomCharacter' => $randomCharacter,
            'charts' => $charts,
            'activeCodes' => $activeCodes
        ]);
    }
}
