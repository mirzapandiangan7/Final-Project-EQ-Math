<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('causer')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.activity-log.index', compact('logs'));
    }

    public function show($id)
    {
        $log = ActivityLog::with('causer', 'subject')->findOrFail($id);

        return view('admin.activity-log.show', compact('log'));
    }

    public function destroy($id)
    {
        $log = ActivityLog::findOrFail($id);
        $log->delete();

        return redirect()->route('admin.activity-log.index')->with([
            'message' => 'Log aktivitas berhasil dihapus',
            'message_type' => 'success',
        ]);
    }
}
