<?php

namespace App\Http\Controllers;

use App\Models\Corridor;
use App\Models\Log;
use Illuminate\Http\Request;

class CorridorController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $corridors = Corridor::select('id', 'name', 'rental_price')->filter()->latest()->paginate(25);
        return view('corridors.index', compact('corridors'));
    }

    public function new()
    {
        return view('corridors.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:corridors,name',
            'rental_price' => 'required|numeric|min:0'
        ]);

        Corridor::create([
            'name' => $request->name,
            'rental_price' => $request->rental_price
        ]);

        $text = ucwords(auth()->user()->name) .  " created Corridor: " . $request->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('corridors')->with('success', 'Corridor was successfully created.');
    }

    public function edit(Corridor $corridor)
    {
        return view('corridors.edit', compact('corridor'));
    }

    public function update(Request $request, Corridor $corridor)
    {
        $request->validate([
            'name' => 'required',
            'rental_price' => 'required|numeric|min:0',
        ]);

        $corridor->update([
            'name' => $request->name,
            'rental_price' => $request->rental_price
        ]);

        $text = ucwords(auth()->user()->name) .  " updated Corridor: " . $corridor->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('corridors')->with('success', 'Corridor was successfully updated.');
    }

    public function destroy(Corridor $corridor)
    {
        if ($corridor->can_delete()) {
            $text = ucwords(auth()->user()->name) .  " deleted Corridor: " . $corridor->name . ", datetime: " . now();
            $corridor->delete();
            Log::create(['text' => $text]);

            return redirect()->back()->with('danger', 'Corridor was successfully deleted');
        } else {
            return redirect()->back()->with('danger', 'Unable to delete');
        }
    }
}
