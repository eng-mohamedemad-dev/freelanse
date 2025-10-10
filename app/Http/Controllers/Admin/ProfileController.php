<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'phone']);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = 'avatar_' . time() . '.' . $avatar->getClientOriginalExtension();
            
            // Create directory if it doesn't exist
            $uploadPath = public_path('uploads/avatars');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            // Delete old avatar if exists
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
            
            // Move the file
            $avatar->move($uploadPath, $filename);
            $data['avatar'] = 'uploads/avatars/' . $filename;
        }

        // Handle password change
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('admin.profile')
                    ->with('password_error', __('admin.current_password_incorrect'))
                    ->withInput();
            }
            $data['password'] = Hash::make($request->new_password);
        }

        $user->update($data);

        return redirect()->route('admin.profile')
            ->with('success', __('admin.profile_updated_successfully'));
    }
}
