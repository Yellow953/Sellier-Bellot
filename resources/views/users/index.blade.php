@extends('layouts.app')

@section('title', 'Users')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title">Actions</h4>

                <div class="d-flex align-items-center">
                    <!-- Filter Button to trigger modal -->
                    <a href="#" class="btn btn-secondary ml-1" data-toggle="modal" data-target="#filterModal">Filter</a>
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
                            @foreach ($users as $user)
                            <tr>
                                <th>{{ ucwords($user->name) }}</th>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucwords($user->role) }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm ml-1"><i class="la la-pencil-square"></i></a>
                                        <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm ml-1"><i class="la la-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Users</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Modal content, such as form fields for filtering users, goes here -->
                <form id="filterForm" action="{{ route('users') }}" method="GET">
                    <div class="form-group">
                        <label for="name">User Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="{{ request('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter email" value="{{ request('email') }}">
                    </div>
                    <div class="form-group">
                        <label for="userRole">Role</label>
                        <select class="form-control" name="role" id="userRole">
                            <option value="">Select Role</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('filterForm').submit();">Apply Filter</button>
            </div>

        </div>
    </div>
</div>
@endsection
