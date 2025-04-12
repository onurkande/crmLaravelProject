<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'max:2048'] // max 2MB
        ]);

        // Profil fotoğrafını güncelle
        if ($request->hasFile('profile_image')) {
            // Eski fotoğrafı sil
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            $imagePath = $request->file('profile_image')->store('profile-images', 'public');
            $user->profile_image = $imagePath;
        }

        $user->name = $request->name;
        $user->email = $request->email;

        // Şifre sadece girilmişse güncellenir
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profiliniz başarıyla güncellendi.');
    }
}
