<?php

namespace App\Http\Controllers;

use App\Models\Caliber;
use App\Models\Lane;
use App\Models\Pistol;
use App\Models\Log;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only('destroy');
    }

    public function index()
    {
        $transactions = Transaction::select('id', 'user_id', 'customer_id', 'transaction_date', 'pistol_source', 'ammo_source', 'total', 'closed')->filter()->latest()->paginate(25);
        return view('transactions.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'pistol_source' => 'required|string',
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
                'pistol_source' => $request->pistol_source,
                'ammo_source' => $request->ammo_source,
                'total' => 0,
                'closed' => $request->closed,
            ]);

            $total = 0;

            foreach ($request->item_type as $index => $itemType) {
                switch ($itemType) {
                    case 'lane':
                        $lane = Lane::find($request->specific_item[$index]);
                        TransactionItem::create([
                            'transaction_id' => $transaction->id,
                            'type' => $itemType,
                            'lane_id' => $lane->id,
                            'quantity' => 1,
                            'unit_price' => $lane->price,
                            'total_price' => $lane->price,
                        ]);
                        $total += $lane->price;
                        break;
                    case 'pistol':
                        $pistol = Pistol::find($request->specific_item[$index]);
                        TransactionItem::create([
                            'transaction_id' => $transaction->id,
                            'type' => $itemType,
                            'pistol_id' => $pistol->id,
                            'quantity' => $request->quantity[$index],
                            'unit_price' => $pistol->price,
                            'total_price' => $request->quantity[$index] * $pistol->price,
                        ]);
                        $total += $request->quantity[$index] * $pistol->price;
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

            if (!$transaction->closed) {
                $text = ucwords(auth()->user()->name) .  " created Transaction: " . $transaction->id . ", datetime: " . now();
                Log::create(['text' => $text]);
            } else {
                $text = ucwords(auth()->user()->name) .  " created and closed Transaction: " . $transaction->id . ", datetime: " . now();
                Log::create(['text' => $text]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Unable to Create Transaction...']);
        }
    }

    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'pistol_source' => 'required|string',
            'ammo_source' => 'required|string',
        ]);

        DB::beginTransaction();
        $user = auth()->user();

        try {
            $transaction->update([
                'transaction_date' => $user->role == 'admin' ? $request->transaction_date : now(),
                'pistol_source' => $request->pistol_source,
                'ammo_source' => $request->ammo_source,
                'closed' => $request->closed,
            ]);

            $total = $transaction->total;

            if ($request->item_type) {
                foreach ($request->item_type as $index => $itemType) {
                    switch ($itemType) {
                        case 'lane':
                            $lane = Lane::find($request->specific_item[$index]);
                            TransactionItem::create([
                                'transaction_id' => $transaction->id,
                                'type' => $itemType,
                                'lane_id' => $lane->id,
                                'quantity' => 1,
                                'unit_price' => $lane->price,
                                'total_price' => $lane->price,
                            ]);
                            $total += $lane->price;
                            break;
                        case 'pistol':
                            $pistol = Pistol::find($request->specific_item[$index]);
                            TransactionItem::create([
                                'transaction_id' => $transaction->id,
                                'type' => $itemType,
                                'pistol_id' => $pistol->id,
                                'quantity' => $request->quantity[$index],
                                'unit_price' => $pistol->price,
                                'total_price' => $request->quantity[$index] * $pistol->price,
                            ]);
                            $total += $request->quantity[$index] * $pistol->price;
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
            }

            $transaction->update(['total' => $total]);

            if (!$transaction->closed) {
                $text = ucwords(auth()->user()->name) .  " updated Transaction: " . $transaction->id . ", datetime: " . now();
                Log::create(['text' => $text]);

                DB::commit();

                return redirect()->back()->with('success', 'Transaction updated successfully.');
            } else {
                $text = ucwords(auth()->user()->name) .  " closed Transaction: " . $transaction->id . ", datetime: " . now();
                Log::create(['text' => $text]);

                DB::commit();

                return redirect()->route('transactions')->with('success', 'Transaction closed successfully.');
            }
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

    public function transaction_item_destroy(TransactionItem $transaction_item)
    {
        if ($transaction_item) {
            $text = ucwords(auth()->user()->name) .  " deleted Transaction Item: " . $transaction_item->id . ", datetime: " . now();

            $transaction = $transaction_item->transaction;
            $transaction_item->delete();
            $transaction->update([
                'total' => $transaction->items->sum('total_price')
            ]);

            Log::create(['text' => $text]);

            return redirect()->back()->with('success', 'Transaction Item Deleted Successfully...');
        } else {
            return redirect()->back()->with('danger', 'Transaction Item Not Available...');
        }
    }

    public function report()
    {
        $date = now()->startOfDay();
        $transactions = Transaction::with(['items'])
            ->whereDate('transaction_date', $date)
            ->get();

        // Close open transactions
        Transaction::where('closed', false)
            ->whereDate('transaction_date', $date)
            ->update(['closed' => true]);

        // Group data for the report
        $calibers = $transactions->flatMap->items->where('type', 'caliber');
        $lanes = $transactions->flatMap->items->where('type', 'lane');
        $pistols = $transactions->flatMap->items->where('type', 'pistol');

        // Analyze specific items
        $caliber_analysis = $this->analyzeItems($calibers, 'caliber');
        $lane_analysis = $this->analyzeItems($lanes, 'lane');
        $pistol_analysis = $this->analyzeItems($pistols, 'pistol');

        $data = [
            'date' => $date->toDateString(),
            'calibers' => $calibers,
            'lanes' => $lanes,
            'pistols' => $pistols,
            'caliber_analysis' => $caliber_analysis,
            'lane_analysis' => $lane_analysis,
            'pistol_analysis' => $pistol_analysis,
            'transactions' => $transactions,
            'calibers_total' => $calibers->sum('quantity'),
            'lanes_total' => $lanes->count(),
            'pistols_total' => $pistols->count(),
            'total_money' => $transactions->sum('total'),
        ];

        $pdf = Pdf::loadView('transactions.report', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->download('daily_report_' . $date->toDateString() . '.pdf');
        // return view('transactions.report', $data);
    }

    public function fetch_options(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:pistol,caliber,lane'
        ]);

        $type = $request->input('type');
        $items = [];

        switch ($type) {
            case 'pistol':
                $items = Pistol::select('id', 'name', 'price')->get();
                break;
            case 'caliber':
                $items = Caliber::select('id', 'name', 'price')->get();
                break;
            case 'lane':
                $items = Lane::select('id', 'name', 'price')->get();
                break;
        }

        return response()->json($items);
    }

    public function fetchTodayTransactions()
    {
        $todayTransactions = Transaction::with('customer:id,name', 'user:id,name')->whereDate('transaction_date', Carbon::today())->orderBy('transaction_date', 'desc')->take(5)->get(['id', 'transaction_date', 'customer_id', 'user_id', 'total']);

        return response()->json($todayTransactions);
    }

    // Private
    private function analyzeItems(Collection $items, string $type)
    {
        return $items->groupBy("{$type}_id")->map(function ($group, $id) use ($type) {
            $name = $group->first()?->{$type}->name ?? 'Unknown';
            return [
                'name' => $name,
                'quantity' => $group->sum('quantity'),
                'total' => $group->sum('total_price'),
            ];
        });
    }
}
