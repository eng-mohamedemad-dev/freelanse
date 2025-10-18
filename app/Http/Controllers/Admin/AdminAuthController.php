<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * معالجة تسجيل الدخول
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // التحقق من دور المستخدم وإعادة التوجيه المناسب
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'مرحباً بك في لوحة التحكم!');
            } else {
                // تسجيل خروج المستخدمين العاديين من لوحة الإدارة
                Auth::logout();
                
                return back()->withErrors([
                    'email' => 'ليس لديك صلاحية للوصول إلى لوحة التحكم.',
                ])->withInput($request->only('email'));
            }
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->withInput($request->only('email'));
    }

    /**
     * تسجيل الخروج
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('success', 'تم تسجيل الخروج بنجاح.');
    }

    /**
     * إنشاء مدير افتراضي (للتطوير فقط)
     */
    public function createDefaultAdmin()
    {
        // تحقق من وجود مدير بالفعل
        if (User::where('email', 'admin@admin.com')->exists()) {
            return redirect()->route('admin.login')
                ->with('info', 'المدير موجود بالفعل.');
        }

        // إنشاء مدير افتراضي
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.login')
            ->with('success', 'تم إنشاء مدير افتراضي: admin@admin.com / 123456');
    }
}
