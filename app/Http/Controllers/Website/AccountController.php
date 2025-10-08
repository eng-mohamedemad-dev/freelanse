<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('website.account.dashboard');
    }

    public function profile()
    {
        return view('website.account.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        auth()->user()->update($request->only(['name', 'email', 'phone']));

        return redirect()->route('website.account.profile')
            ->with('success', __('website.profile_updated_successfully'));
    }

    public function addresses()
    {
        return view('website.account.addresses');
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        // Here you would store the address
        // For now, we'll just return success
        
        return redirect()->route('website.account.addresses')
            ->with('success', __('website.address_added_successfully'));
    }

    public function updateAddress(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        // Here you would update the address
        
        return redirect()->route('website.account.addresses')
            ->with('success', __('website.address_updated_successfully'));
    }

    public function deleteAddress($id)
    {
        // Here you would delete the address
        
        return redirect()->route('website.account.addresses')
            ->with('success', __('website.address_deleted_successfully'));
    }
}