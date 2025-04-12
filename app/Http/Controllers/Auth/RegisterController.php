<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\NewUserRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\UserType;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'desired_role' => ['required', 'string', 'in:admin,sales_consultant,agency'],
        ]);

        $data = $request->all();
        
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('users/profile', 'public');
            $data['profile_image'] = $imagePath;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'profile_image' => $data['profile_image'] ?? null
        ]);

        // Kullanıcının istediği rolü kaydet
        UserType::create([
            'user_id' => $user->id,
            'desired_role' => $data['desired_role']
        ]);

        // Tüm admin kullanıcılara mail gönder
        $adminUsers = User::where('user_type', 'admin')->get();
        foreach($adminUsers as $admin) {
            Mail::to($admin->email)->send(new NewUserRegistered($user));
        }

        // Kullanıcıyı oturum açtır
        Auth::login($user);

        // Kullanıcıyı başarı sayfasına yönlendir ve oturumu kapat
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('registration.success');
    }

    public function showRegistrationSuccess()
    {
        return view('auth.registration-success');
    }
} 