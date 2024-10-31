@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
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
                    <h4 class="card-title">New Customer? <a href="{{ route('customers.new') }}">Create</a></h4>
                </div>
            </div>
        </div>

        <!-- Transaction Form Section -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body" id="transaction_form_container">
                    Please Choose a Customer ...
                </div>
            </div>
        </div>
    </div>
</div>
@include('scripts.dashboard')
@endsection