<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\User;
use App\Models\Note;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AnalysisController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->user_type === 'admin';

        // Admin için tüm veriler
        if ($isAdmin) {
            $data = [
                'totalAdvertisements' => Advertisement::count(),
                'totalAgencies' => User::where('user_type', 'agency')->count(),
                'totalAdmins' => User::where('user_type', 'admin')->count(),
                'totalConsultants' => User::where('user_type', 'sales_consultant')->count(),
                'totalSoldAdvertisements' => Advertisement::where('sale_status', 'Satıldı')->count(),
                'totalEarnings' => Advertisement::where('sale_status', 'Satıldı')
                    ->select(DB::raw('SUM(price - COALESCE(debt_amount, 0)) as total_earnings'))
                    ->value('total_earnings'),
                'soldByRoomType' => Advertisement::where('sale_status', 'Satıldı')
                    ->select('room_type', DB::raw('count(*) as total'))
                    ->groupBy('room_type')
                    ->get()
                    ->pluck('total', 'room_type')
                    ->toArray(),
                'recentAdvertisements' => Advertisement::with('images')
                    ->latest()
                    ->take(5)
                    ->get(),
                'recentlySoldAdvertisements' => Advertisement::with('images')
                    ->where('sale_status', 'Satıldı')
                    ->latest()
                    ->take(5)
                    ->get(),
                'recentNotes' => Note::latest()
                    ->take(5)
                    ->get(),
            ];
        }
        // Danışman için kısıtlı veriler
        else {
            $data = [
                'totalAdvertisements' => Advertisement::where('created_by', $user->id)->count(),
                'totalSoldAdvertisements' => Advertisement::where('created_by', $user->id)
                    ->where('sale_status', 'Satıldı')
                    ->count(),
                'totalEarnings' => Advertisement::where('created_by', $user->id)
                    ->where('sale_status', 'Satıldı')
                    ->select(DB::raw('SUM(price - COALESCE(debt_amount, 0)) as total_earnings'))
                    ->value('total_earnings'),
                'soldByRoomType' => Advertisement::where('created_by', $user->id)
                    ->where('sale_status', 'Satıldı')
                    ->select('room_type', DB::raw('count(*) as total'))
                    ->groupBy('room_type')
                    ->get()
                    ->pluck('total', 'room_type')
                    ->toArray(),
                'recentAdvertisements' => Advertisement::with('images')
                    ->where('created_by', $user->id)
                    ->latest()
                    ->take(5)
                    ->get(),
                'recentlySoldAdvertisements' => Advertisement::with('images')
                    ->where('created_by', $user->id)
                    ->where('sale_status', 'Satıldı')
                    ->latest()
                    ->take(5)
                    ->get(),
            ];
        }

        $data['isAdmin'] = $isAdmin;
        
        return view('admin.Analysis.index', $data);
    }
} 