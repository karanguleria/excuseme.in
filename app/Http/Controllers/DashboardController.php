<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Table;
use App\Models\TableCall;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isSuperAdmin()) {
            return redirect()->route('super-admin.restaurants.index');
        }
        
        $tables = Table::where('restaurant_id', $user->restaurant_id)
            ->with('latestCall')
            ->orderBy('table_number')
            ->get();
        
        return view('dashboard.index', compact('tables'));
    }

    public function getTables()
    {
        $user = auth()->user();
        
        $tables = Table::where('restaurant_id', $user->restaurant_id)
            ->with(['latestCall' => function($query) {
                $query->where('status', 'ringing');
            }])
            ->orderBy('table_number')
            ->get();
        
        return response()->json($tables);
    }

    public function acknowledgeCall($tableId)
    {
        $user = auth()->user();
        $table = Table::where('restaurant_id', $user->restaurant_id)
            ->findOrFail($tableId);
        
        $activeCall = $table->calls()
            ->where('status', 'ringing')
            ->latest()
            ->first();
        
        if ($activeCall) {
            $activeCall->update([
                'status' => 'acknowledged',
                'acknowledged_at' => now()
            ]);
            
            $table->update(['is_ringing' => false]);
        }
        
        return response()->json(['success' => true]);
    }
}
