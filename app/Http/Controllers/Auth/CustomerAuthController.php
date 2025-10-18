<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CustomerAuthController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول للعملاء
     */
    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    /**
     * عرض صفحة التسجيل للعملاء
     */
    public function showRegisterForm()
    {
        return view('customer.auth.register');
    }

    /**
     * معالجة تسجيل الدخول للعملاء
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
            if ($user->isCustomer()) {
                return redirect()->intended('/')
                    ->with('success', 'مرحباً بك في المتجر!');
            } else {
                // تسجيل خروج المديرين من الموقع الأمامي
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return back()->withErrors([
                    'email' => 'هذا الحساب مخصص للوحة التحكم.',
                ])->withInput($request->only('email'));
            }
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->withInput($request->only('email'));
    }

    /**
     * معالجة تسجيل العملاء الجدد
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        Auth::login($user);

        return redirect('/')
            ->with('success', 'تم إنشاء حسابك بنجاح! مرحباً بك في المتجر.');
    }

    /**
     * تسجيل الخروج
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')
            ->with('success', 'تم تسجيل الخروج بنجاح.');
    }
}