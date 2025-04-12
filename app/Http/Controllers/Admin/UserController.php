<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'in:admin,sales_consultant,agency,user'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        $data = $request->all();
        
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('users/profile', 'public');
            $data['profile_image'] = $imagePath;
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type' => $data['user_type'],
            'profile_image' => $data['profile_image'] ?? null,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarıyla oluşturuldu.');
    }

    public function edit(User $user)
    {
        // Kullanıcı kendi profilini düzenliyorsa
        $isSelfEdit = Auth::id() === $user->id;
        return view('admin.users.edit', compact('user', 'isSelfEdit'));
    }

    public function update(Request $request, User $user)
    {
        // Kullanıcı kendi profilini düzenliyorsa user_type değiştirilemesin
        if (Auth::id() === $user->id) {
            $request->request->remove('user_type'); // user_type parametresini kaldır
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'user_type' => [Auth::id() !== $user->id ? 'required' : 'prohibited', 'in:admin,sales_consultant,agency,user'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048']
        ]);

        $data = $request->except('password');
        
        if ($request->hasFile('profile_image')) {
            // Eski resmi sil
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $imagePath = $request->file('profile_image')->store('users/profile', 'public');
            $data['profile_image'] = $imagePath;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Kendi profilini düzenlerken user_type'ı koruyalım
        if (Auth::id() === $user->id) {
            $data['user_type'] = $user->user_type;
        }

        $user->update($data);

        return back()->with('success', 'Kullanıcı başarıyla güncellendi.');
    }

    public function destroy(User $user)
    {
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }
        
        $user->delete();

        return redirect()->route('admin.users.index')->with('deleted', 'Kullanıcı başarıyla silindi.');
    }
} 