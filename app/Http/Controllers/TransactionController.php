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
        $transactions = Transaction::select('id', 'user_id', 'customer_id', 'transaction_date', 'gun_source', 'ammo_source', 'total')->filter()->latest()->paginate(25);
        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'gun_source' => 'required|string',
            'ammo_source' => 'required|string',
            'item_type' => 'required|array',
            'specific_item' => 'required|array'
        ]);

        DB::beginTransaction();
        $user = auth()->user();

        try {
            $transaction = Transaction::create([
                'user_id' => $request->user_id,
                'customer_id' => $request->customer_id,
                'transaction_date' => $user->role == 'admin' ? $request->transaction_date : now(),
                'gun_source' => $request->gun_source,
                'ammo_source' => $request->ammo_source,
                'total' => 0
            ]);

            $total = 0;

            foreach ($request->item_type as $index => $itemType) {
                switch ($itemType) {
                    case 'corridor':
                        $corridor = Corridor::find($request->specific_item[$index]);
                        TransactionItem::create([
                            'transaction_id' => $transaction->id,
                            'type' => $itemType,
                            'corridor_id' => $corridor->id,
                            'quantity' => 1,
                            'unit_price' => $corridor->price,
                            'total_price' => $corridor->price,
                        ]);
                        $total += $corridor->price;
                        break;
                    case 'gun':
                        $gun = Gun::find($request->specific_item[$index]);
                        TransactionItem::create([
                            'transaction_id' => $transaction->id,
                            'type' => $itemType,
                            'gun_id' => $gun->id,
                            'quantity' => $request->quantity[$index],
                            'unit_price' => $gun->price,
                            'total_price' => $request->quantity[$index] * $gun->price,
                        ]);
                        $total += $request->quantity[$index] * $gun->price;
                        break;
                    case 'caliber':
                        $caliber = Caliber::find($request->specific_item[$index]);
                        TransactionItem::create([
                            'transaction_id' => $transaction->id,
                            'type' => $itemType,
                            'caliber_id' => $caliber->id,
                            'quantity' => $request->quantity[$index],
                            'unit_price' => $caliber->price,
                            'total_price' => $request->quantity[$index] * $caliber->price,
                        ]);
                        $total += $request->quantity[$index] * $caliber->price;
                        break;
                    default:
                        break;
                }
            }

            $transaction->update(['total' => $total]);

            $text = ucwords(auth()->user()->name) .  " created Transaction: " . $transaction->id . ", datetime: " . now();
            Log::create(['text' => $text]);

            DB::commit();

            return redirect()->back()->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Unable to Create Transaction...']);
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
