<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patch;
use Illuminate\Http\JsonResponse;

class PatchController extends Controller
{
    /**
     * Get detailed patch information for modal display
     */
    public function show(Patch $patch): JsonResponse
    {
        $patch->load(['storyArc', 'characters', 'lightcones']);
        
        return response()->json([
            'id' => $patch->id,
            'name' => $patch->name,
            'formatted_number' => $patch->formatted_number,
            'formatted_duration' => $patch->formatted_duration,
            'description' => $patch->description,
            'img' => asset($patch->img),
            'story_arc' => $patch->storyArc ? [
                'name' => $patch->storyArc->name,
                'img' => $patch->storyArc->img
            ] : null,
            'characters' => $patch->characters->map(function ($character) {
                return [
                    'id' => $character->id,
                    'name' => $character->name,
                    'icon_img' => asset($character->icon_img),
                    'rarity' => $character->rarity,
                    'element' => $character->element,
                    'path' => $character->path
                ];
            }),
            'lightcones' => $patch->lightcones->map(function ($lightcone) {
                return [
                    'id' => $lightcone->id,
                    'name' => $lightcone->name,
                    'img' => asset($lightcone->img),
                    'rarity' => $lightcone->rarity,
                    'path' => $lightcone->path
                ];
            })
        ]);
    }
}