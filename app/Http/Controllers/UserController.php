<?php

namespace App\Http\Controllers;

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->where('role_id','!=',0)->get();
        $roles = Role::get();
        return view('users',compact('users','roles'));

      // return response()->json($users);
    }

    
    public function store(Request $request)
    {

        $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|email|unique:users',
            'phone'         => 'required|regex:/^(\+\d{1,3}[-\.\s]??)?\d{10}$/',
            'description'   => 'nullable|string',
            'role_id'       => 'required',
            'profile_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->description = $request->input('description');
        $user->role_id = $request->input('role_id');
        if ($request->hasFile('profile_image')) {
            $user->profile_image = $request->file('profile_image')->store('public/profile_images', 'public');
        }
        $user->save();

        return response()->json(['message' => 'User created successfully.','user'=>$user]);
    }

    public function show($id)
    {
        $user = User::with('role')->find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|regex:/^(\+\d{1,3}[-\.\s]??)?\d{10}$/',
            'description' => 'nullable|string',
            'role_id' => 'required',
            'profile_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->description = $request->input('description');
        $user->role_id = $request->input('role_id');
        if ($request->hasFile('profile_image')) {
            $user->profile_image = $request->file('profile_image')->store('public/profile_images', 'public');
        }
        $user->save();

        return response()->json(['message' => 'User updated successfully.']);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }

}
