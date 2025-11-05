<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = ActivityLog::with('user')
            ->latest()
            ->limit(50)
            ->get();
            
        return view('admin.activity-logs', compact('activities'));
    }

    public function logBulkDelete(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|min:1',
            'equipment_name' => 'required|string',
            'action' => 'required|string'
        ]);

        ActivityLogService::logBulkInstancesDeleted(
            $request->count,
            $request->equipment_name,
            $request
        );

        return response()->json(['success' => true]);
    }

    public function logBulkRetire(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|min:1',
            'equipment_name' => 'required|string',
            'action' => 'required|string'
        ]);

        ActivityLogService::logBulkInstancesRetired(
            $request->count,
            $request->equipment_name,
            $request
        );

        return response()->json(['success' => true]);
    }
}
