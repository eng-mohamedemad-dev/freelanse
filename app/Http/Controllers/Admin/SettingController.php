<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'متجر إلكتروني'),
            'site_logo' => Setting::get('site_logo', ''),
            'points_system_enabled' => Setting::getBoolean('points_system_enabled', false),
            'points_per_dollar' => Setting::getInteger('points_per_dollar', 1),
            'wheel_enabled' => Setting::getBoolean('wheel_enabled', false),
            'max_wheel_spins_per_day' => Setting::getInteger('max_wheel_spins_per_day', 1),
            'default_language' => Setting::get('default_language', 'ar'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'points_system_enabled' => 'boolean',
            'points_per_dollar' => 'required|integer|min:1',
            'wheel_enabled' => 'boolean',
            'max_wheel_spins_per_day' => 'required|integer|min:1|max:10',
            'default_language' => 'required|in:ar,en',
        ]);

        // Update basic settings
        Setting::set('site_name', $request->site_name);
        Setting::set('points_system_enabled', $request->boolean('points_system_enabled'));
        Setting::set('points_per_dollar', $request->points_per_dollar);
        Setting::set('wheel_enabled', $request->boolean('wheel_enabled'));
        Setting::set('max_wheel_spins_per_day', $request->max_wheel_spins_per_day);
        Setting::set('default_language', $request->default_language);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');
            $filename = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $path = $logo->storeAs('uploads/settings', $filename, 'public');
            
            // Delete old logo if exists
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            Setting::set('site_logo', $path);
        }

        return redirect()->route('admin.settings')
            ->with('success', __('admin.settings_updated_successfully'));
    }
}
