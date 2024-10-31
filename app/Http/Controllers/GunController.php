<?php

namespace App\Http\Controllers;

use App\Models\Gun;
use App\Models\Log;
use Illuminate\Http\Request;

class GunController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $guns = Gun::select('id', 'name', 'make', 'price')->filter()->latest()->paginate(25);
        return view('guns.index', compact('guns'));
    }

    public function new()
    {
        return view('guns.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:guns,name',
            'make' => 'required',
            'price' => 'required|numeric|min:0'
        ]);

        Gun::create([
            'name' => $request->name,
            'make' => $request->make,
            'price' => $request->price
        ]);

        $text = ucwords(auth()->user()->name) .  " created Gun: " . $request->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('guns')->with('success', 'Gun was successfully created.');
    }

    public function edit(Gun $gun)
    {
        return view('guns.edit', compact('gun'));
    }

    public function update(Request $request, Gun $gun)
    {
        $request->validate([
            'name' => 'required',
            'make' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $gun->update([
            'name' => $request->name,
            'make' => $request->make,
            'price' => $request->price
        ]);

        $text = ucwords(auth()->user()->name) .  " updated Gun: " . $gun->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('guns')->with('success', 'Gun was successfully updated.');
    }

    public function destroy(Gun $gun)
    {
        if ($gun->can_delete()) {
            $text = ucwords(auth()->user()->name) .  " deleted Gun: " . $gun->name . ", datetime: " . now();
            $gun->delete();
            Log::create(['text' => $text]);

            return redirect()->back()->with('danger', 'Gun was successfully deleted');
        } else {
            return redirect()->back()->with('danger', 'Unable to delete');
        }
    }
}
