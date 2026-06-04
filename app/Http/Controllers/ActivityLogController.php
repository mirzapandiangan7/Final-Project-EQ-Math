<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ActivityLogController extends Controller
{
    /**
     * Daftar log aktivitas
     */
    public function index(): View
    {
        $logs = ActivityLog::query()
            ->with('causer')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.activity-log.index', compact('logs'));
    }

    /**
     * Detail log aktivitas
     */
    public function show($id): View
    {
        /** @var ActivityLog $log */
        $log = ActivityLog::query()->with(['causer', 'subject'])->findOrFail($id);

        return view('admin.activity-log.show', compact('log'));
    }

    /**
     * Hapus log aktivitas
     */
    public function destroy($id): RedirectResponse
    {
        /** @var ActivityLog $log */
        $log = ActivityLog::query()->findOrFail($id);
        $log->delete();

        return redirect()->route('admin.activity-log.index')->with([
            'message' => 'Log aktivitas berhasil dihapus',
            'message_type' => 'success',
        ]);
    }
}
