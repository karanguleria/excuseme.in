<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\TableCall;

class GuestController extends Controller
{
    public function show($uniqueUrl)
    {
        $table = Table::where('unique_url', $uniqueUrl)->firstOrFail();
        
        return view('guest.index', compact('table'));
    }

    public function ring(Request $request, $uniqueUrl)
    {
        $table = Table::where('unique_url', $uniqueUrl)->firstOrFail();
        
        // Check if already ringing
        $activeCall = $table->calls()
            ->where('status', 'ringing')
            ->latest()
            ->first();
        
        if (!$activeCall) {
            // Create new call
            TableCall::create([
                'table_id' => $table->id,
                'status' => 'ringing',
                'called_at' => now()
            ]);
            
            $table->update(['is_ringing' => true]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Waiter has been notified!'
        ]);
    }

    public function stopRing($uniqueUrl)
    {
        $table = Table::where('unique_url', $uniqueUrl)->firstOrFail();
        
        // Mark active call as completed
        $activeCall = $table->calls()
            ->where('status', 'ringing')
            ->latest()
            ->first();
        
        if ($activeCall) {
            $activeCall->update([
                'status' => 'completed',
                'completed_at' => now()
            ]);
        }
        
        $table->update(['is_ringing' => false]);
        
        return response()->json([
            'success' => true,
            'message' => 'Call cancelled'
        ]);
    }

    public function checkStatus($uniqueUrl)
    {
        $table = Table::where('unique_url', $uniqueUrl)
            ->with(['latestCall' => function($query) {
                $query->where('status', 'ringing');
            }])
            ->firstOrFail();
        
        return response()->json([
            'is_ringing' => $table->is_ringing,
            'has_active_call' => $table->latestCall !== null
        ]);
    }
}
