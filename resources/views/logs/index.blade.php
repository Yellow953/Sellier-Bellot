@extends('layouts.app')

@section('title', 'Logs')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title">Actions</h4>
                <div class="d-flex align-items-center">
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
                    <table class="table table-bordered mb-0">
                        <tbody>
                            @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->text }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center">No Logs found...</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    {{ $logs->appends([
                                    'text' => request()->query('text'),
                                    'startDate' => request()->query('startDate'),
                                    'endDate' => request()->query('endDate')
                                    ])->links() }}
                                </td>
                            </tr>
                        </tfoot>
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
                <h5 class="modal-title" id="filterModalLabel">Filter Logs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="filterForm" action="{{ route('logs') }}" method="GET" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="text">Text</label>
                        <input type="text" class="form-control" name="text" id="text" placeholder="Search log message"
                            value="{{ request()->query('text') }}">
                    </div>
                    <div class="form-group">
                        <label for="startDate">Start Date</label>
                        <input type="date" class="form-control" name="startDate" id="startDate"
                            value="{{ request()->query('startDate') }}">
                    </div>
                    <div class="form-group">
                        <label for="endDate">End Date</label>
                        <input type="date" class="form-control" name="endDate" id="endDate"
                            value="{{ request()->query('endDate') }}">
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
