<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $user = auth()->user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        Log::create([
            'text' => ucwords(auth()->user()->name) .  ' updated his/her Profile, datetime: ' . now(),
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function save_password(Request $request)
    {
        $request->validate([
            'new_password' => 'required|max:255|confirmed',
        ]);

        $user = auth()->user();

        $user->update([
            'password' => Hash::make(
                $request->new_password
            )
        ]);

        Log::create([
            'text' => ucwords($user->name) . ' changed his password, datetime: ' . now(),
        ]);

        return redirect()->back()->with('success', 'Password Changed Successfully...');
    }
}
