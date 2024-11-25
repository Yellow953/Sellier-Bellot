@extends('layouts.app')

@section('title', 'Pistols')

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between my-2">
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm d-flex align-items-center"><i
                class="la la-angle-left"></i> BACK</a>
        <h2>Edit Pistol</h2>
    </div>

    <form action="{{ route('pistols.update', $pistol->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Name *</label>
            <fieldset class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $pistol->name }}"
                    required>
            </fieldset>
        </div>

        <div class="form-group">
            <label for="make">Make *</label>
            <fieldset class="form-group">
                <input type="text" name="make" class="form-control" placeholder="Enter Make" value="{{ $pistol->make }}"
                    required>
            </fieldset>
        </div>

        <div class="form-group">
            <label for="price">Price *</label>
            <fieldset class="form-group">
                <input type="double" name="price" class="form-control" placeholder="Enter Price"
                    value="{{ $pistol->price }}" required>
            </fieldset>
        </div>

        <button type="submit" class="btn btn-info btn-block">
            Update
        </button>
    </form>
</div>
@endsection