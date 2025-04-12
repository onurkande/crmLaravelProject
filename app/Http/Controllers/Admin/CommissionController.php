<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\CommissionsExport;
use Maatwebsite\Excel\Facades\Excel;

class CommissionController extends Controller
{
    public function index()
    {
        $consultants = User::where('user_type', 'sales_consultant')->get();
        $commissions = Commission::with('consultant')->latest()->paginate(10);
        
        return view('admin.commissions.index', compact('consultants', 'commissions'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'consultant_id' => ['required', 'exists:users,id'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $commission_amount = ($request->price * $request->percentage) / 100;

        Commission::create([
            'price' => $request->price,
            'consultant_id' => $request->consultant_id,
            'percentage' => $request->percentage,
            'commission_amount' => $commission_amount,
            'calculated_by' => Auth::id()
        ]);

        return redirect()->route('admin.commissions.index')
            ->with('success', 'Komisyon hesaplaması başarıyla kaydedildi.');
    }

    public function clearAll()
    {
        Commission::truncate();
        return redirect()->route('admin.commissions.index')
            ->with('success', 'Tüm komisyon kayıtları başarıyla temizlendi.');
    }

    public function export()
    {
        return Excel::download(new CommissionsExport, 'komisyonlar.xlsx');
    }

    public function edit(Commission $commission)
    {
        $consultants = User::where('user_type', 'sales_consultant')->get();
        return view('admin.commissions.edit', compact('commission', 'consultants'));
    }

    public function update(Request $request, Commission $commission)
    {
        $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'consultant_id' => ['required', 'exists:users,id'],
            'percentage' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $commission_amount = ($request->price * $request->percentage) / 100;

        $commission->update([
            'price' => $request->price,
            'consultant_id' => $request->consultant_id,
            'percentage' => $request->percentage,
            'commission_amount' => $commission_amount,
        ]);

        return back()->with('success', 'Komisyon başarıyla güncellendi.');
    }

    public function destroy(Commission $commission)
    {
        $commission->delete();
        return redirect()->route('admin.commissions.index')
            ->with('success', 'Komisyon başarıyla silindi.');
    }
} 