<?php

namespace App\Http\Controllers;

use App\Models\Lane;
use App\Models\Log;
use Illuminate\Http\Request;

class LaneController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $lanes = Lane::select('id', 'name', 'price')->filter()->latest()->paginate(25);
        return view('lanes.index', compact('lanes'));
    }

    public function new()
    {
        return view('lanes.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:lanes,name',
            'price' => 'required|numeric|min:0'
        ]);

        Lane::create([
            'name' => $request->name,
            'price' => $request->price
        ]);

        $text = ucwords(auth()->user()->name) .  " created Lane: " . $request->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('lanes')->with('success', 'Lane was successfully created.');
    }

    public function edit(Lane $lane)
    {
        return view('lanes.edit', compact('lane'));
    }

    public function update(Request $request, Lane $lane)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $lane->update([
            'name' => $request->name,
            'price' => $request->price
        ]);

        $text = ucwords(auth()->user()->name) .  " updated Lane: " . $lane->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('lanes')->with('success', 'Lane was successfully updated.');
    }

    public function destroy(Lane $lane)
    {
        if ($lane->can_delete()) {
            $text = ucwords(auth()->user()->name) .  " deleted Lane: " . $lane->name . ", datetime: " . now();
            $lane->delete();
            Log::create(['text' => $text]);

            return redirect()->back()->with('danger', 'Lane was successfully deleted');
        } else {
            return redirect()->back()->with('danger', 'Unable to delete');
        }
    }
}
