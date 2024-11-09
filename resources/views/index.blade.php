@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<style>
    #today_transactions_container {
        display: flex;
        overflow-x: auto;
        padding: 15px;
        gap: 15px;
    }

    #today_transactions_container .transaction-item {
        min-width: 200px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: space-between;
        text-align: center;
        transition: transform 0.2s;
    }

    #today_transactions_container .transaction-item:hover {
        transform: scale(1.07);
    }

    #today_transactions_container .transaction-item div {
        margin-bottom: 5px;
        font-size: 0.9rem;
    }

    #today_transactions_container::-webkit-scrollbar {
        height: 8px;
    }

    #today_transactions_container::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    #today_transactions_container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    #today_transactions_container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .clickable-transaction {
        cursor: pointer;
        transition: transform 0.2s;
    }

    .clickable-transaction:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="container">
    <div class="row">
        <!-- Customer Search Section -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Customers</h4>
                </div>
                <div class="card-body">
                    <div class="form-group d-flex align-items-center">
                        <input type="text" name="customer_search" id="customer_search" class="form-control"
                            placeholder="Search Customer" autofocus>
                        <button id="customer_search_btn" class="btn btn-info btn-sm ml-1"><i
                                class="la la-search"></i></button>
                    </div>
                    <div class="customers_list" id="customers_list"></div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">New Customer? <a href="{{ route('customers.new') }}"
                            class="text-info">Create</a></h4>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Transaction Form Section -->
            <div class="card">
                <div class="card-body" id="transaction_form_container">
                    Please Choose a Customer ...
                </div>
            </div>

            <!-- Today's Transactions Section -->
            <div class="card">
                <div class="card-body" id="today_transactions_container">
                    Today's Transactions ...
                </div>
            </div>
        </div>
    </div>
</div>
@include('scripts.dashboard')
@endsection
