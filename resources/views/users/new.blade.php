@extends('layouts.app')

@section('title', 'Users')

@php
$roles = Helper::get_user_roles();
@endphp

@section('content')
<div class="container">
    <div class="d-flex align-items-center justify-content-between my-2">
        <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm d-flex align-items-center"><i
                class="la la-angle-left"></i> BACK</a>
        <h2>New User</h2>
    </div>

    <form action="{{ route('users.create') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Name *</label>
            <fieldset class="form-group">
                <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}"
                    required>
            </fieldset>
        </div>

        <div class="form-group">
            <label for="email">Email *</label>
            <fieldset class="form-group">
                <input type="email" name="email" class="form-control" placeholder="Enter Email"
                    value="{{ old('email') }}" required>
            </fieldset>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number *</label>
            <fieldset class="form-group">
                <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number"
                    value="{{ old('phone') }}" required>
            </fieldset>
        </div>

        <div class="form-group">
            <label for="role">Role *</label>
            <fieldset class="form-group">
                <select class="form-control" name="role" required>
                    <option>Select an option...</option>
                    @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ $role==old('role') ? 'selected' : '' }}>{{ ucwords($role) }}</option>
                    @endforeach
                </select>
            </fieldset>
        </div>

        <div class="form-group">
            <label for="password">Password *</label>
            <fieldset class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Enter Password"
                    value="{{ old('password') }}" required>
            </fieldset>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Password Confirmation *</label>
            <fieldset class="form-group">
                <input type="password" name="password_confirmation" class="form-control"
                    placeholder="Enter Password Again" value="{{ old('password_confirmation') }}" required>
            </fieldset>
        </div>

        <button type="submit" class="btn btn-info btn-block">
            Create
        </button>
    </form>
</div>
@endsection