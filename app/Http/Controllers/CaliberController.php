<?php

namespace App\Http\Controllers;

use App\Models\Caliber;
use App\Models\Log;
use Illuminate\Http\Request;

class CaliberController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $calibers = Caliber::select('id', 'name', 'make', 'rental_price')->filter()->latest()->paginate(25);
        return view('calibers.index', compact('calibers'));
    }

    public function new()
    {
        return view('calibers.new');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:calibers,name',
            'make' => 'required',
            'rental_price' => 'required|numeric|min:0'
        ]);

        Caliber::create([
            'name' => $request->name,
            'make' => $request->make,
            'rental_price' => $request->rental_price
        ]);

        $text = ucwords(auth()->user()->name) .  " created Caliber: " . $request->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('calibers')->with('success', 'Caliber was successfully created.');
    }

    public function edit(Caliber $caliber)
    {
        return view('calibers.edit', compact('caliber'));
    }

    public function update(Request $request, Caliber $caliber)
    {
        $request->validate([
            'name' => 'required',
            'make' => 'required',
            'rental_price' => 'required|numeric|min:0',
        ]);

        $caliber->update([
            'name' => $request->name,
            'make' => $request->make,
            'rental_price' => $request->rental_price
        ]);

        $text = ucwords(auth()->user()->name) .  " updated Caliber: " . $caliber->name . ", datetime: " . now();
        Log::create(['text' => $text]);

        return redirect()->route('calibers')->with('success', 'Caliber was successfully updated.');
    }

    public function destroy(Caliber $caliber)
    {
        if ($caliber->can_delete()) {
            $text = ucwords(auth()->user()->name) .  " deleted Caliber: " . $caliber->name . ", datetime: " . now();
            $caliber->delete();
            Log::create(['text' => $text]);

            return redirect()->back()->with('danger', 'Caliber was successfully deleted');
        } else {
            return redirect()->back()->with('danger', 'Unable to delete');
        }
    }
}
