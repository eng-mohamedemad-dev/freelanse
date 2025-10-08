<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Services\WheelService;
use App\Models\WheelPrize;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WheelController extends Controller
{
    protected $wheelService;

    public function __construct(WheelService $wheelService)
    {
        $this->wheelService = $wheelService;
    }

    public function index()
    {
        $isEnabled = Setting::getBoolean('wheel_enabled', false);
        $prizes = WheelPrize::where('is_active', true)->get();
        
        return view('website.wheel.index', compact('isEnabled', 'prizes'));
    }

    public function spin(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً'
            ], 401);
        }

        $result = $this->wheelService->spinWheel(
            Auth::id(),
            $request->ip(),
            $request->userAgent()
        );

        return response()->json($result);
    }

    public function claim(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً'
            ], 401);
        }

        $request->validate([
            'spin_id' => 'required|integer',
            'security_hash' => 'required|string',
        ]);

        $result = $this->wheelService->claimPrize(
            $request->spin_id,
            $request->security_hash,
            Auth::id()
        );

        return response()->json($result);
    }

    public function prizes()
    {
        $prizes = WheelPrize::where('is_active', true)->get();
        
        return response()->json($prizes);
    }
}
