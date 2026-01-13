<?php

namespace App\Http\Controllers;

use App\Models\Relic;
use App\Models\PlanarOrnament;
use Illuminate\Http\Request;

class RelicsController extends Controller
{
    public function index() 
    {
        $selectedItem = null;

        try {
            $relics = Relic::all();
            $planarOrnaments = PlanarOrnament::all();

            $items = collect()
                ->merge($relics->map(fn($relic) => $relic->setAttribute('item_type', 'relic')))
                ->merge($planarOrnaments->map(fn($planar) => $planar->setAttribute('item_type', 'planar')));
        } catch (\Exception $e) {
            $items = collect();
        }

        return view('relics.index', compact('items', 'selectedItem'));
    }

    public function show($type, $item) 
    {
        if (!in_array($type, ['relic', 'planar'])) {
            abort(404);
        }

        $modelClass = $type === 'relic' ? Relic::class : PlanarOrnament::class;
        
        $selectedItem = app($modelClass)->resolveRouteBinding($item);
        
        if (!$selectedItem) {
            abort(404);
        }
        
        $selectedItem->setAttribute('item_type', $type);
        
        $relics = Relic::all();
        $planarOrnaments = PlanarOrnament::all();
        $items = collect()
            ->merge($relics->map(fn($r) => $r->setAttribute('item_type', 'relic')))
            ->merge($planarOrnaments->map(fn($p) => $p->setAttribute('item_type', 'planar')));

        return view('relics.index', compact('items', 'selectedItem'));
    }
}
