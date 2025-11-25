<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    /**
     * Method untuk admin melihat semua activity log.
     */
    public function adminIndex()
    {
        // Ambil semua log beserta relasi user, urut terbaru, pagination 20
        $logs = ActivityLog::with('user')->latest()->paginate(20);

        return view('activity_logs.admin_index', compact('logs'));
    }

    /**
     * Method untuk user melihat activity log dirinya sendiri.
     */
    public function userIndex()
    {
        $logs = ActivityLog::with('user')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->paginate(20);

        return view('activity_logs.user_index', compact('logs'));
    }
}
