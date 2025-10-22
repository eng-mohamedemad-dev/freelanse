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

    public function create()
    {
        $permissions = \App\Models\Permission::active()->get();
        return view('admin.users.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,user',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'is_active' => $request->is_active == '1'
        ]);

        // منح الصلاحيات المحددة
        if ($request->has('permissions')) {
            $permissions = \App\Models\Permission::whereIn('id', $request->permissions)->get();
            foreach ($permissions as $permission) {
                $user->grantPermission($permission);
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', __('admin.user_created_successfully'));
    }

    public function edit(User $user)
    {
        $permissions = \App\Models\Permission::active()->get();
        $userPermissions = $user->permissions()->pluck('permissions.id')->toArray();
        return view('admin.users.edit', compact('user', 'permissions', 'userPermissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,user',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->is_active == '1'
        ];

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        $user->update($userData);

        // تحديث الصلاحيات
        $user->permissions()->detach();
        if ($request->has('permissions')) {
            $permissions = \App\Models\Permission::whereIn('id', $request->permissions)->get();
            foreach ($permissions as $permission) {
                $user->grantPermission($permission);
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', __('admin.user_updated_successfully'));
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