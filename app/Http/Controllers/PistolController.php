<?php

namespace App\Http\Controllers;

use App\Models\Pistol;
use App\Models\Log;
use Illuminate\Http\Request;

class PistolController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $pistols = Pistol::select('id', 'name', 'make', 'price')->filter()->latest()->paginate(25);
        return view('pistols.index', compact('pistols'));
    }

    public function new()
    {
        return view('pistols.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:pistols,name',
            'make' => 'required',
            'price' => 'required|numeric|min:0'
        ]);

        Pistol::create([
            'name' => $request->name,
            'make' => $request->make,
            'price' => $request->price
        ]);

        $text = ucwords(auth()->user()->name) .  " created Pistol: " . $request->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('pistols')->with('success', 'Pistol was successfully created.');
    }

    public function edit(Pistol $pistol)
    {
        return view('pistols.edit', compact('pistol'));
    }

    public function update(Request $request, Pistol $pistol)
    {
        $request->validate([
            'name' => 'required',
            'make' => 'required',
            'price' => 'required|numeric|min:0',
        ]);

        $pistol->update([
            'name' => $request->name,
            'make' => $request->make,
            'price' => $request->price
        ]);

        $text = ucwords(auth()->user()->name) .  " updated Pistol: " . $pistol->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('pistols')->with('success', 'Pistol was successfully updated.');
    }

    public function destroy(Pistol $pistol)
    {
        if ($pistol->can_delete()) {
            $text = ucwords(auth()->user()->name) .  " deleted Pistol: " . $pistol->name . ", datetime: " . now();
            $pistol->delete();
            Log::create(['text' => $text]);

            return redirect()->back()->with('danger', 'Pistol was successfully deleted');
        } else {
            return redirect()->back()->with('danger', 'Unable to delete');
        }
    }
}
