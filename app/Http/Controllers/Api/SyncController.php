<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SyncController extends Controller
{
    public function __construct(SyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    public function store(Request $request)
    {
        $changes = $request->all();
        Log::info('SYNC RECEIVED', ['payload' => $changes]);

        if (!is_array($changes)) {
            return response()->json(['error' => 'Invalid payload, expected an array of changes.'], 422);
        }

        DB::beginTransaction();

        try {
            $this->syncService->applyChanges($changes);
            DB::commit();

            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to apply changes',
            ], 500);
        }
    }   
}