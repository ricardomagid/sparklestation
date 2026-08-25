<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GachaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GachaController extends Controller
{
    public function submitPull(Request $request, GachaService $gachaService)
    {
        $validated = $request->validate([
            'pullCount' => 'required|integer|in:1,10',
            'type'      => 'required|string|in:character,lightcone',
            'itemId'    => 'required|integer',
        ]);

        $data = $gachaService->processPull(
            Auth::user(),
            $validated['pullCount'],
            $validated['type'],
            $validated['itemId']
        );

        return response()->json($data);
    }
}