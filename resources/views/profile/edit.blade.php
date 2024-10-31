@extends('layouts.app')

@section('title', 'profile')

@php
$roles = Helper::get_user_roles();
@endphp

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header text-center">
                <img src="{{ asset('assets/images/default_profile.png') }}" alt="" class="profile_pic" width="150"
                    height="150">
            </div>
            <div class="card-body text-center">
                <h2><u>Name:</u> {{ ucwords($user->name) }}</h2>
                <h3 class="mt-2"><u>Email:</u> {{ $user->email }}</h3>
                <h4 class="mt-2 text-info">{{ ucwords($user->role) }}</h4>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-header">
                Change Password
            </div>
            <div class="card-body">
                <form action="{{ route('profile.save_password') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="new_password">New Password *</label>
                        <fieldset class="form-group">
                            <input type="password" name="new_password" class="form-control"
                                placeholder="Enter New Password" required>
                        </fieldset>
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">Password Confirmation *</label>
                        <fieldset class="form-group">
                            <input type="password" name="new_password_confirmation" class="form-control"
                                placeholder="Enter New Password Again" required>
                        </fieldset>
                    </div>

                    <button type="submit" class="btn btn-info btn-block">
                        Change Password
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                Edit Profile
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name *</label>
                        <fieldset class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                value="{{ $user->name }}" required>
                        </fieldset>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <fieldset class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Enter Email"
                                value="{{ $user->email }}" required>
                        </fieldset>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <fieldset class="form-group">
                            <input type="tel" name="phone" class="form-control" placeholder="Enter Phone Number"
                                value="{{ $user->phone }}" required>
                        </fieldset>
                    </div>

                    <div class="form-group">
                        <label for="role">Role *</label>
                        <fieldset class="form-group">
                            <select class="form-control" name="role" required>
                                <option>Select an option...</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ $role==$user->role ? 'selected' : '' }}>{{ ucwords($role)
                                    }}</option>
                                @endforeach
                            </select>
                        </fieldset>
                    </div>

                    <button type="submit" class="btn btn-info btn-block">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
