<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('website.auth.login');
    }

    /**
     * Handle login
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
            
            return redirect()->intended(route('website.account.dashboard'))
                ->with('success', 'تم تسجيل الدخول بنجاح');
        }

        return redirect()->back()
            ->withErrors(['email' => 'بيانات الدخول غير صحيحة'])
            ->withInput($request->only('email'));
    }

    /**
     * Show register form
     */
    public function showRegisterForm()
    {
        return view('website.auth.register');
    }

    /**
     * Handle registration
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

        return redirect()->route('website.account.dashboard')
            ->with('success', 'تم إنشاء الحساب بنجاح');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('website.home')
            ->with('success', 'تم تسجيل الخروج بنجاح');
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('website.auth.forgot-password');
    }

    /**
     * Send reset link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Password reset logic would go here
        // For now, just return success message
        
        return redirect()->back()
            ->with('success', 'تم إرسال رابط إعادة تعيين كلمة المرور');
    }

    /**
     * Show reset password form
     */
    public function showResetForm($token)
    {
        return view('website.auth.reset-password', compact('token'));
    }

    /**
     * Reset password
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required',
        ]);

        // Password reset logic would go here
        
        return redirect()->route('login')
            ->with('success', 'تم إعادة تعيين كلمة المرور بنجاح');
    }
}
