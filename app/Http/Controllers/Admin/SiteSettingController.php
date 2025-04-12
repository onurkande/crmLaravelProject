<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::first() ?? new SiteSetting();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'mail_username' => 'required|email',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required',
            'footer_content' => 'nullable|string',
        ]);

        $settings = SiteSetting::first() ?? new SiteSetting();

        // Logo işlemi
        if ($request->hasFile('logo')) {
            if ($settings->logo) {
                Storage::disk('public')->delete($settings->logo);
            }
            $settings->logo = $request->file('logo')->store('settings', 'public');
        }

        // Favicon işlemi
        if ($request->hasFile('favicon')) {
            if ($settings->favicon) {
                Storage::disk('public')->delete($settings->favicon);
            }
            $settings->favicon = $request->file('favicon')->store('settings', 'public');
        }

        // Mail ve uygulama ayarlarını güncelle
        $settings->app_name = $request->app_name;
        $settings->mail_username = $request->mail_username;
        $settings->mail_password = $request->mail_password;
        $settings->mail_encryption = $request->mail_encryption;
        $settings->mail_from_address = $request->mail_from_address;
        $settings->mail_from_name = $request->mail_from_name;
        $settings->footer_content = $request->footer_content;

        $settings->save();

        // .env dosyasını güncelle
        $path = base_path('.env');
        if (File::exists($path)) {
            $content = File::get($path);

            $content = preg_replace([
                '/^APP_NAME=.*/m',
                '/^MAIL_USERNAME=.*/m',
                '/^MAIL_PASSWORD=.*/m',
                '/^MAIL_ENCRYPTION=.*/m',
                '/^MAIL_FROM_ADDRESS=.*/m',
                '/^MAIL_FROM_NAME=.*/m'
            ], [
                'APP_NAME="' . $request->app_name . '"',
                'MAIL_USERNAME=' . $request->mail_username,
                'MAIL_PASSWORD=' . $request->mail_password,
                'MAIL_ENCRYPTION=' . $request->mail_encryption,
                'MAIL_FROM_ADDRESS="' . $request->mail_from_address . '"',
                'MAIL_FROM_NAME="' . $request->mail_from_name . '"'
            ], $content);

            File::put($path, $content);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Site ayarları başarıyla güncellendi.');
    }
} 