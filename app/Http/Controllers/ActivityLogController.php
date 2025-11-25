<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index()
    {
        if(Auth::user()->role == 'admin') {
            // Admin bisa lihat semua log
            $logs = ActivityLog::with('user')->latest()->paginate(20);
        } else {
            // User hanya bisa lihat log dirinya sendiri
            $logs = ActivityLog::with('user')
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->paginate(20);
        }

        return view('activity_logs.index', compact('logs'));
    }
}
