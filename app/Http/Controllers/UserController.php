<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('fields')) {
            $fields = $request->input('fields');
            foreach ($fields as $field => $value) {
                if (!empty($value)) {
                    $query->where($field, 'LIKE', "%{$value}%");
                }
            }
        } else {
            $query->latest();
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => bcrypt($request->password)

        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    public function show(Request $request)
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile' => 'required',
            'password' => 'min:6',
            'password_confirmation' => 'same:password'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
        ];

        if (!empty($request->password)) {
            $data['password'] = bcrypt($request->password);
        }

        $user = User::findOrFail($id);
        $user->update($data);


        if ($request->profile) {
            return redirect()->route('profile')->with('success', 'Profile updated successfully');
        }
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('error', 'User deleted successfully');
    }


    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $user = User::findOrFail($id);

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect');
        }

        // Update password
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('profile')->with('success', 'Password updated successfully');
    }
}
