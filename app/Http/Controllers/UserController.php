<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $users = User::select('id', 'name', 'email', 'phone', 'role')->filter()->latest()->paginate(25);
        return view('users.index', compact('users'));
    }

    public function new()
    {
        return view('users.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'role' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        $text = ucwords(auth()->user()->name) .  " created User: " . $request->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('users')->with('success', 'User was successfully created.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'role' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        $text = ucwords(auth()->user()->name) .  " updated User: " . $user->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('users')->with('success', 'User was successfully updated.');
    }

    public function destroy(User $user)
    {
        if ($user->can_delete()) {
            $text = ucwords(auth()->user()->name) .  " deleted User: " . $user->name . ", datetime: " . now();
            $user->delete();
            Log::create(['text' => $text]);

            return redirect()->back()->with('danger', 'User was successfully deleted');
        } else {
            return redirect()->back()->with('danger', 'Unable to delete');
        }
    }
}
