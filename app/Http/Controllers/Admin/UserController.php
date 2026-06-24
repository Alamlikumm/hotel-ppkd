<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->paginate(15);

        confirmDelete('Delete User!', 'Are you sure you want to delete this user?');

        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // auto-hashed via cast
            'role_id' => $request->role_id,
        ]);

        Alert::success('Success', 'User Added Successfully.');

        return back()->with('success', 'User Added Successfully.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'boolean',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'role_id', 'is_active');

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        Alert::success('Success', 'User Updated Successfully.');

        return back()->with('success', 'User Updated Successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->isSuperAdmin()) {
            Alert::error('Error', 'Superadmin Cannot Be Deleted.');

            return back()->with('error', 'Superadmin Cannot Be Deleted.');
        }

        $user->delete();

        Alert::success('Success', 'User Has Been Successfully Deleted.');

        return back()->with('success', 'User Has Been Successfully Deleted.');
    }
}
