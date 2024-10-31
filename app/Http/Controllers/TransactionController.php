<?php

namespace App\Http\Controllers;

use App\Models\Caliber;
use App\Models\Corridor;
use App\Models\Gun;
use App\Models\Log;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['edit', 'update', 'destroy']);
    }

    public function index()
    {
        $transactions = Transaction::select('id', 'user_id', 'customer_id', 'transaction_date')->filter()->latest()->paginate(25);
        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'transaction_date' => 'required|date',
            'gun_source' => 'required|string',
            'ammo_source' => 'required|string',
            'item_type' => 'required|array',
            'specific_item' => 'required|array',
            'quantity' => 'required|array',
            'unit_price' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $transaction = Transaction::create([
                'user_id' => $request->user_id,
                'customer_id' => $request->customer_id,
                'transaction_date' => $request->transaction_date,
                'gun_source' => $request->gun_source,
                'ammo_source' => $request->ammo_source,
            ]);

            foreach ($request->item_type as $index => $itemType) {
                switch ($itemType) {
                    case 'corridor':
                        TransactionItem::create([
                            'transaction_id' => $transaction->id,
                            'type' => $itemType,
                            'corridor_id' => $request->specific_item[$index],
                            'quantity' => $request->quantity[$index],
                            'unit_price' => $request->unit_price[$index],
                            'total_price' => $request->quantity[$index] * $request->unit_price[$index],
                        ]);
                        break;
                    case 'gun':
                        TransactionItem::create([
                            'transaction_id' => $transaction->id,
                            'type' => $itemType,
                            'gun_id' => $request->specific_item[$index],
                            'quantity' => $request->quantity[$index],
                            'unit_price' => $request->unit_price[$index],
                            'total_price' => $request->quantity[$index] * $request->unit_price[$index],
                        ]);
                        break;
                    case 'caliber':
                        TransactionItem::create([
                            'transaction_id' => $transaction->id,
                            'type' => $itemType,
                            'caliber_id' => $request->specific_item[$index],
                            'quantity' => $request->quantity[$index],
                            'unit_price' => $request->unit_price[$index],
                            'total_price' => $request->quantity[$index] * $request->unit_price[$index],
                        ]);
                        break;

                    default:

                        break;
                }
            }

            $text = ucwords(auth()->user()->name) .  " created Transaction: " . $transaction->id . ", datetime: " . now();
            Log::create(['text' => $text]);

            DB::commit();

            return redirect()->back()->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create transaction. Please try again.']);
        }
    }

    public function destroy(Transaction $transaction)
    {
        if ($transaction->can_delete()) {
            foreach ($transaction->items as $item) {
                $item->delete();
            }

            $text = ucwords(auth()->user()->name) .  " deleted Transaction: " . $transaction->id . ", datetime: " . now();

            $transaction->delete();

            Log::create(['text' => $text]);

            return redirect()->back()->with('danger', 'Transaction was successfully deleted');
        } else {
            return redirect()->back()->with('danger', 'Unable to delete');
        }
    }

    public function show(Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

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
