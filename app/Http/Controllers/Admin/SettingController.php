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
            'site_logo' => Setting::get('site_logo', ''),
            'site_name' => Setting::get('site_name', config('app.name')),
            'points_system_enabled' => Setting::getBoolean('points_system_enabled', false),
            'points_count' => Setting::getInteger('points_count', 20),
            'points_discount' => Setting::getInteger('points_discount', 1),
            'wheel_enabled' => Setting::getBoolean('wheel_enabled', false),
            'max_wheel_spins_per_day' => Setting::getInteger('max_wheel_spins_per_day', 1),
            'wheel_prizes' => Setting::get('wheel_prizes', []),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'points_system_enabled' => 'boolean',
            'points_count' => 'required_if:points_system_enabled,1|integer|min:1',
            'points_discount' => 'required_if:points_system_enabled,1|integer|min:1|max:100',
            'wheel_enabled' => 'boolean',
            'max_wheel_spins_per_day' => 'required_if:wheel_enabled,1|integer|min:1|max:10',
            'wheel_prizes' => 'nullable|array',
            'wheel_prizes.*.name' => 'required_if:wheel_enabled,1|string|max:255',
            'wheel_prizes.*.value' => 'required_if:wheel_enabled,1|numeric|min:0',
            'wheel_prizes.*.type' => 'required_if:wheel_enabled,1|in:points,discount,cash',
        ]);

        // Update settings
        Setting::set('points_system_enabled', $request->boolean('points_system_enabled') ? '1' : '0');
        
        // Only update points fields if points system is enabled
        if ($request->boolean('points_system_enabled')) {
            Setting::set('points_count', (string)($request->points_count ?? 20));
            Setting::set('points_discount', (string)($request->points_discount ?? 1));
        } else {
            Setting::set('points_count', '20');
            Setting::set('points_discount', '1');
        }
        
        Setting::set('wheel_enabled', $request->boolean('wheel_enabled') ? '1' : '0');
        
        // Only update wheel fields if wheel is enabled
        if ($request->boolean('wheel_enabled')) {
            Setting::set('max_wheel_spins_per_day', (string)($request->max_wheel_spins_per_day ?? 1));
        } else {
            Setting::set('max_wheel_spins_per_day', '1');
        }
        
        // Handle wheel prizes only if wheel is enabled
        if ($request->boolean('wheel_enabled') && $request->has('wheel_prizes')) {
            $prizes = [];
            foreach ($request->wheel_prizes as $prize) {
                if (!empty($prize['name']) && !empty($prize['value'])) {
                    $prizes[] = [
                        'name' => $prize['name'],
                        'value' => $prize['value'],
                        'type' => $prize['type'],
                    ];
                }
            }
            Setting::set('wheel_prizes', $prizes);
        } else {
            // Clear wheel prizes if wheel is disabled
            Setting::set('wheel_prizes', []);
        }

        // Update site name
        Setting::set('site_name', $request->site_name ?? config('app.name'));

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $logo = $request->file('site_logo');
            $ext = strtolower($logo->getClientOriginalExtension() ?: 'png');
            $uploadDir = public_path('uploads/settings');
            if (!is_dir($uploadDir)) { mkdir($uploadDir, 0755, true); }

            // Remove any previous logo.* files to keep واحد فقط
            foreach (glob($uploadDir . '/logo.*') as $old) { @unlink($old); }

            // Save as logo.{ext}
            $filename = 'logo.' . $ext;
            $logo->move($uploadDir, $filename);
            $path = 'uploads/settings/' . $filename;

            // Keep Setting for other أماكن تستخدمه
            Setting::set('site_logo', $path);
        }

        try {
            return redirect()->route('admin.settings')
                ->with('success', __('admin.settings_updated_successfully'));
        } catch (\Exception $e) {
            \Log::error('Settings update error: ' . $e->getMessage());
            return redirect()->route('admin.settings')
                ->with('error', __('admin.error_occurred_message'));
        }
    }
}
