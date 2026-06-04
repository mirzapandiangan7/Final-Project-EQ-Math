<?php

namespace App\Http\Controllers;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class ActivityLogController extends Controller
{
    /**
     * Daftar log aktivitas
     */
    public function index(Request $request): View
    {
        $logs = ActivityLog::query()
            ->with('causer')
            // Filter berdasarkan role user (causer)
            ->when($request->role, function($query) use ($request) {
                return $query->whereHas('causer', function($q) use ($request) {
                    $q->where('role', $request->role);
                });
            })
            // FITUR PENCARIAN: Berdasarkan nama aktor (causer)
            ->when($request->search, function($query) use ($request) {
                return $query->whereHas('causer', function($q) use ($request) {
                    $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.activity-log.index', compact('logs'));
    }

    /**
     * FITUR AUTOCOMPLETE: Mengambil daftar nama user untuk prediksi ketik
     */
    public function autocompleteUser(Request $request): JsonResponse
    {
        $search = $request->query('q');

        if (!$search) {
            return response()->json([]);
        }

        $users = User::query()
            ->where('nama_lengkap', 'like', '%' . $search . '%')
            ->select('id', 'nama_lengkap')
            ->limit(8)
            ->get();

        return response()->json($users);
    }

    /**
     * Detail log aktivitas
     */
    public function show(Request $request, $id)
    {
        /** @var ActivityLog $log */
        $log = ActivityLog::query()->with(['causer', 'subject'])->findOrFail($id);

        // Jika request via AJAX, kirimkan JSON (untuk modal)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $log->id,
                    'created_at' => $log->created_at->format('d M Y H:i:s'),
                    'actor' => $log->causer ? $log->causer->nama_lengkap : 'System',
                    'description' => $log->description,
                    'subject' => class_basename($log->subject_type) . ' (ID: ' . $log->subject_id . ')',
                    'properties' => $log->properties, // Mengirim data JSON properti
                ]
            ]);
        }

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
