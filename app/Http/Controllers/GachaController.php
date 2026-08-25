<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Lightcone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GachaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $limitedChars = Character::where('is_standard', false)
                                    ->where('rarity', 5)
                                    ->get();
        
        $limitedLcs = Lightcone::where('is_standard', false)
                                ->where('rarity', 5)
                                ->get();

        $characterPity = $user->pities()
            ->where('type', 'character')
            ->where('rarity', 5)
            ->first();

        $lightconePity = $user->pities()
            ->where('type', 'lightcone')
            ->where('rarity', 5)
            ->first();

        $featuredCharacter = $user->featuredCharacter ?? $limitedChars->last();
        $featuredLightcone = $user->featuredLightcone ?? $limitedLcs->last();

        return view('gacha.index', compact(
            'limitedChars',
            'limitedLcs',
            'characterPity',
            'lightconePity',
            'featuredCharacter',
            'featuredLightcone'
        ));
    }
}
