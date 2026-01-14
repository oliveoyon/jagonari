<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Storage;

class GeneralSettingController extends Controller
{
    // Show form
    public function edit()
    {
        $setting = GeneralSetting::first();

        if (!$setting) {
            $setting = GeneralSetting::create([]);
        }

        return view('admin.general_settings.edit', compact('setting'));
    }

    // Update form
    public function update(Request $request)
    {
        $setting = GeneralSetting::first();

        if (!$setting) {
            $setting = GeneralSetting::create([]);
        }

        $data = $request->only([
            'site_name', 'tagline', 'phone1', 'phone2', 'email1', 'email2',
            'address', 'footer_text', 'google_map_url', 'facebook_url', 'twitter_url',
            'linkedin_url'
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            if ($setting->favicon) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->back()->with('success', 'সেটিংস সফলভাবে আপডেট হয়েছে।');
    }
}
