@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between my-2">
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm d-flex align-items-center"><i
                class="la la-angle-left"></i> BACK</a>
        <h2>Edit Customer</h2>
    </div>

    <div class="row">
        <div class="col-md-9">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name">Name *</label>
                    <fieldset class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Enter Name"
                            value="{{ $customer->name }}" required>
                    </fieldset>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number *</label>
                    <fieldset class="form-group">
                        <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number"
                            value="{{ $customer->phone }}" required>
                    </fieldset>
                </div>

                <div class="form-group">
                    <label for="address">Address *</label>
                    <fieldset class="form-group">
                        <input type="text" name="address" class="form-control" placeholder="Enter Address"
                            value="{{ $customer->address }}" required>
                    </fieldset>
                </div>

                <button type="submit" class="btn btn-info btn-block">
                    Update
                </button>
            </form>
        </div>
        <div class="col-md-3">
            <div class="document_section text-center">
                <h3 class="text-info">{{ ucwords($customer->document_type) }}:</h3>
                <img src="{{ $customer->document }}" class="document"> <br>
                <a href="{{ route('customers.download', $customer->id) }}" class="btn btn-info mt-1">Download</a>
            </div>
        </div>
    </div>
</div>
@endsection
