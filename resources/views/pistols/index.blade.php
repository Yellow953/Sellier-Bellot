@extends('layouts.app')

@section('title', 'Pistols')
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
                    <a href="#" class="btn btn-secondary ml-1" data-toggle="modal" data-target="#filterModal">Filter</a>
                    <a href="{{ route('pistols.new') }}" class="btn btn-info ml-1">New Pistol</a>
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
                                <th>Make</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pistols as $pistol)
                            <tr>
                                <th>{{ ucwords($pistol->name) }}</th>
                                <td>{{ ucwords($pistol->make) }}</td>
                                <td>${{ number_format($pistol->price, 2) }}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        @if ($auth_user->role == 'admin')
                                        <a href="{{ route('pistols.edit', $pistol->id) }}"
                                            class="btn btn-warning btn-sm ml-1"><i class="la la-pencil-square"></i></a>
                                        @if ($pistol->can_delete())
                                        <a href="{{ route('pistols.destroy', $pistol->id) }}"
                                            class="btn btn-danger btn-sm ml-1 show_confirm" data-toggle="tooltip"
                                            data-original-title="Delete pistol"><i class="la la-trash"></i></a>
                                        @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">No Pistols yet ...</td>
                            </tr>
                            @endforelse

                            <tr>
                                <td colspan="4">{{ $pistols->appends(['name' => request()->query('name'),
                                    'make' =>
                                    request()->query('make'), 'phone' =>
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

<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter pistols</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="filterForm" action="{{ route('pistols') }}" method="GET" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Pistol Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name..."
                            value="{{ request()->query('name') }}">
                    </div>
                    <div class="form-group">
                        <label for="make">Make</label>
                        <input type="text" class="form-control" name="make" id="make" placeholder="Enter Make..."
                            value="{{ request()->query('make') }}">
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