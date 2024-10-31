@extends('layouts.app')

@section('title', 'Users')

@php
$auth_user = auth()->user();
@endphp

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title">Actions</h4>

                <div class="d-flex align-items-center">
                    <a href="#" class="btn btn-secondary ml-1">Filter</a>
                    <a href="{{ route('users.new') }}" class="btn btn-info ml-1">New User</a>
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
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr>
                                <th>{{ ucwords($user->name) }}</th>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucwords($user->role) }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        @if ($auth_user->role == 'admin')
                                        <a href="{{ route('users.edit', $user->id) }}"
                                            class="btn btn-warning btn-sm ml-1"><i class="la la-pencil-square"></i></a>
                                        @if ($user->can_delete())
                                        <a href="{{ route('users.destroy', $user->id) }}"
                                            class="btn btn-danger btn-sm ml-1 show_confirm" data-toggle="tooltip"
                                            data-original-title="Delete User"><i class="la la-trash"></i></a>
                                        @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No Users yet ...</td>
                            </tr>
                            @endforelse

                            <tr>
                                <td colspan="4">{{ $users->appends(['name' => request()->query('name'),
                                    'email' =>
                                    request()->query('email'), 'phone' =>
                                    request()->query('phone'), 'role' =>
                                    request()->query('role')])->links() }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection