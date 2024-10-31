@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Transaction Details</h2>
        </div>
        <div class="card-body">
            <!-- Main Transaction Information -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h3 class="mb-1">Customer Information</h3>
                    <p><strong>Name:</strong> {{ $transaction->customer->name }}</p>
                    <p><strong>Phone:</strong> {{ $transaction->customer->phone }}</p>
                    <p><strong>Address:</strong> {{ $transaction->customer->address }}</p>
                </div>
                <div class="col-md-6">
                    <h3 class="mb-1">Transaction Information</h3>
                    <p><strong>Date:</strong> {{ $transaction->transaction_date }}</p>
                    <p><strong>Gun Source:</strong> {{ $transaction->gun_source }}</p>
                    <p><strong>Ammo Source:</strong> {{ $transaction->ammo_source }}</p>
                </div>
            </div>

            <!-- Transaction Items Table -->
            <h5 class="mb-3">Transaction Items</h5>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Item Type</th>
                        <th>Specific Item</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->items as $item)
                    <tr>
                        <td>{{ ucfirst($item->type) }}</td>
                        <td>
                            @switch($item->type)
                            @case('corridor')
                            {{ ucwords($item->corridor->name) }}
                            @break
                            @case('gun')
                            {{ ucwords($item->gun->name) }}
                            @break
                            @case('caliber')
                            {{ ucwords($item->caliber->name) }}
                            @break
                            @default

                            @endswitch
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->unit_price, 2) }}</td>
                        <td>${{ number_format($item->total_price, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Total Amount -->
            <div class="text-right mt-3">
                <h5><strong>Total Amount:</strong> ${{ number_format($transaction->items->sum('total_price'), 2) }}</h5>
            </div>
        </div>

        <div class="card-footer text-right">
            <a href="{{ route('transactions') }}" class="btn btn-secondary">Back to Transactions</a>
        </div>
    </div>
</div>
@endsection
