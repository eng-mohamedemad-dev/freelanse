<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }


        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        // If AJAX request, return only table content
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'html' => view('admin.users.partials.table', compact('users'))->render(),
                'count' => $users->count()
            ]);
        }

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            
            return response()->json([
                'success' => true,
                'message' => __('admin.user_deleted_successfully')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.error_deleting_user')
            ], 500);
        }
    }
}