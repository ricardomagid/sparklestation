<?php

namespace App\Http\Controllers;

use App\Models\Patch;
use App\Models\StoryArc;
use App\Models\Character;
use Illuminate\Http\Request;

class PatchesController extends Controller
{
    public function index() {
        try {
            $patches = Patch::with(['storyArc', 'characters', 'lightcones'])
                        ->orderBy('start_date', 'desc')
                        ->get();
        } catch (\Exception $e) {
            $patches = collect();
        }

        return view('patches.index', compact('patches'));
    }
}
