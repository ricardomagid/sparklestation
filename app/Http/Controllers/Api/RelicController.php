<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Relic;
use App\Models\PlanarOrnament;
use Illuminate\Http\JsonResponse;

class RelicController extends Controller
{
    public function getRelicData(Relic $selectedItem) {
        $selectedItem->load(['relicPieces', 'relicPieces.type']);
        $selectedItem->setAttribute('item_type', 'relic');

        return view('relics.partials.relic-details', compact('selectedItem'));
    }

    public function getPlanarData(PlanarOrnament $selectedItem) {
        $selectedItem->load(['planarOrnamentPieces', 'planarOrnamentPieces.type']);
        $selectedItem->setAttribute('item_type', 'planar');

        return view('relics.partials.relic-details', compact('selectedItem'));
    }
}