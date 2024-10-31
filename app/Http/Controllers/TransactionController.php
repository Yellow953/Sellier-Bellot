<?php

namespace App\Http\Controllers;

use App\Models\Caliber;
use App\Models\Corridor;
use App\Models\Gun;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['edit', 'update', 'destroy']);
    }

    public function index()
    {
        $transactions = Transaction::select('id', 'user_id', 'customer_id', 'gun_source', 'ammo_source')->filter()->latest()->paginate(25);
        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request) {}

    public function destroy(Transaction $transaction) {}

    public function fetch_options(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:gun,caliber,corridor'
        ]);

        $type = $request->input('type');
        $items = [];

        switch ($type) {
            case 'gun':
                $items = Gun::select('id', 'name', 'price')->get();
                break;
            case 'caliber':
                $items = Caliber::select('id', 'name', 'price')->get();
                break;
            case 'corridor':
                $items = Corridor::select('id', 'name', 'price')->get();
                break;
        }

        return response()->json($items);
    }
}
