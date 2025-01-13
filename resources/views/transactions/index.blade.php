@extends('layouts.app')

@section('title', 'Transactions')

@php
$auth_user = auth()->user();
$users = Helper::get_users();
$customers = Helper::get_customers();
@endphp

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title">Actions</h4>

                <div class="d-flex align-items-center">
                    <a href="{{ route('home') }}" class="btn btn-success ml-1">New Transaction</a>
                    <a href="{{ route('transactions.report') }}" class="btn btn-info ml-1">Generate Daily Report</a>
                    <a href="#" class="btn btn-secondary ml-1" data-toggle="modal" data-target="#filterModal">Filter</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">@yield('title')</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Customer</th>
                                <th>Info</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $transaction)
                            <tr>
                                <td>
                                    <b>{{ $transaction->id }}</b> <br>
                                    <span class="{{ $transaction->closed ? 'text-danger' : 'text-info' }}">{{
                                        $transaction->closed ? 'Closed' : 'Open' }}</span>
                                </td>
                                <td><b>{{ ucwords($transaction->user->name) }}</b></td>
                                <td>
                                    <b>{{ ucwords($transaction->customer->name ) }}</b><br>
                                    {{ $transaction->customer->phone }} <br>
                                    {{ $transaction->customer->document_type }} <br>
                                    {{ $transaction->customer->address }}
                                </td>
                                <td>
                                    <b>{{ $transaction->transaction_date }}</b> <br>
                                    Pistol Source: {{ $transaction->pistol_source}} <br>
                                    Ammo Source: {{ $transaction->ammo_source }}

                                </td>
                                <td>${{ number_format($transaction->total, 2) }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('transactions.show', $transaction->id) }}"
                                            class="btn btn-info btn-sm ml-1"><i class="la la-eye"></i></a>

                                        @if( !$transaction->closed )
                                        <a href="{{ route('transactions.edit', $transaction->id) }}"
                                            class="btn btn-warning btn-sm ml-1"><i class="la la-edit"></i></a>
                                        @endif

                                        @if ($transaction->can_delete())
                                        <a href="{{ route('transactions.destroy', $transaction->id) }}"
                                            class="btn btn-danger btn-sm ml-1 show_confirm" data-toggle="tooltip"
                                            data-original-title="Delete Transaction"><i class="la la-trash"></i></a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">No Transactions yet ...</td>
                            </tr>
                            @endforelse

                            <tr>
                                <td colspan="6">{{ $transactions->appends(['user_id' => request()->query('user_id'),
                                    'customer_id' =>
                                    request()->query('customer_id'), 'transaction_date' =>
                                    request()->query('transaction_date')])->links() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Transactions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="filterForm" action="{{ route('transactions') }}" method="GET" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="user_id">User</label>
                        <select class="form-control" name="user_id" id="user_id">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request()->query('user_id')==$user->id ? 'selected' : ''
                                }}>{{
                                ucwords($user->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="customer_id">Customer</label>
                        <select class="form-control" name="customer_id" id="customer_id">
                            <option value="">Select Customer</option>
                            @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" {{ request()->query('customer_id')==$customer->id ?
                                'selected' : ''
                                }}>{{
                                ucwords($customer->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="transaction_start_date">Transaction Start Date</label>
                        <input type="date" class="form-control" name="transaction_start_date" id="transaction_start_date"
                            value="{{ request()->query('transaction_start_date') }}">
                    </div>

 		   <div class="form-group">
                        <label for="transaction_end_date">Transaction End Date</label>
                        <input type="date" class="form-control" name="transaction_end_date" id="transaction_end_date"
                            value="{{ request()->query('transaction_end_date') }}">
                    </div>


                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info"
                    onclick="document.getElementById('filterForm').submit();">Apply Filter</button>
            </div>

        </div>
    </div>
</div>
@endsection